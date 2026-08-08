<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FixedAssetResource\Pages;
use App\Models\AssetDepreciation;
use App\Models\FixedAsset;
use App\Models\JournalEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FixedAssetResource extends Resource
{
    protected static ?string $model = FixedAsset::class;

    protected static ?string $navigationGroup = '🏦 Asset';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?int $navigationSort = 20;
    protected static ?string $modelLabel = 'Aset Tetap';
    protected static ?string $pluralModelLabel = 'Aset Tetap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\TextInput::make('asset_code')
                    ->required()
                    ->maxLength(255)
                    ->label('Kode Aset'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Aset'),
                Forms\Components\TextInput::make('category')
                    ->maxLength(255)
                    ->label('Kategori'),
                Forms\Components\DatePicker::make('acquisition_date')
                    ->required()
                    ->label('Tgl Perolehan'),
                Forms\Components\TextInput::make('acquisition_cost')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Biaya Perolehan'),
                Forms\Components\TextInput::make('residual_value')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Nilai Residu'),
                Forms\Components\TextInput::make('useful_life_months')
                    ->required()
                    ->integer()
                    ->default(0)
                    ->label('Umur Ekonomis (bulan)'),
                Forms\Components\Select::make('depreciation_method')
                    ->required()
                    ->options([
                        'straight_line' => 'Garis Lurus',
                        'double_declining' => 'Saldo Menurun',
                    ])
                    ->label('Metode Penyusutan'),
                Forms\Components\Select::make('asset_account_id')
                    ->relationship('assetAccount', 'name')
                    ->searchable()
                    ->label('Akun Aset'),
                Forms\Components\Select::make('accum_depr_account_id')
                    ->relationship('accumDeprAccount', 'name')
                    ->searchable()
                    ->label('Akun Akumulasi Penyusutan'),
                Forms\Components\Select::make('expense_account_id')
                    ->relationship('expenseAccount', 'name')
                    ->searchable()
                    ->label('Akun Beban Penyusutan'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->label('Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset_code')
                    ->label('Kode Aset')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Aset')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('acquisition_date')
                    ->label('Tgl Perolehan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('acquisition_cost')
                    ->label('Biaya Perolehan')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('depreciation_method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'straight_line' => 'info',
                        'double_declining' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('run_depreciation')
                    ->label('Hitung Penyusutan')
                    ->icon('heroicon-o-calculator')
                    ->color('warning')
                    ->action(fn (FixedAsset $record) => static::runDepreciation($record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function runDepreciation(FixedAsset $asset): void
    {
        $monthlyDepr = 0;

        if ($asset->depreciation_method === 'straight_line') {
            $depreciable = $asset->acquisition_cost - $asset->residual_value;
            $monthlyDepr = $asset->useful_life_months > 0
                ? $depreciable / $asset->useful_life_months
                : 0;
        } elseif ($asset->depreciation_method === 'double_declining') {
            $totalDepreciations = AssetDepreciation::where('asset_id', $asset->id)->sum('depreciation_amount');
            $currentBookValue = $asset->acquisition_cost - $totalDepreciations;
            $rate = $asset->useful_life_months > 0
                ? (2 / $asset->useful_life_months)
                : 0;
            $monthlyDepr = max($currentBookValue * $rate, $currentBookValue - $asset->residual_value);
            if ($currentBookValue <= $asset->residual_value) {
                $monthlyDepr = 0;
            }
        }

        $lastDepr = AssetDepreciation::where('asset_id', $asset->id)->latest()->first();
        $accumulated = ($lastDepr ? $lastDepr->accumulated_amount : 0) + $monthlyDepr;
        $bookValue = $asset->acquisition_cost - $accumulated;

        $journalEntry = JournalEntry::create([
            'tenant_id' => $asset->tenant_id,
            'journal_no' => 'DEPR-' . date('Ymd') . '-' . $asset->id,
            'journal_date' => now()->format('Y-m-d'),
            'reference' => 'Penyusutan: ' . $asset->name,
            'description' => 'Penyusutan bulanan aset: ' . $asset->name,
            'is_posted' => true,
            'posted_at' => now(),
        ]);

        $journalEntry->lines()->create([
            'account_id' => $asset->expense_account_id,
            'debit' => $monthlyDepr,
            'credit' => 0,
            'description' => 'Beban penyusutan - ' . $asset->name,
        ]);

        $journalEntry->lines()->create([
            'account_id' => $asset->accum_depr_account_id,
            'debit' => 0,
            'credit' => $monthlyDepr,
            'description' => 'Akumulasi penyusutan - ' . $asset->name,
        ]);

        AssetDepreciation::create([
            'asset_id' => $asset->id,
            'period' => now()->format('Y-m'),
            'depreciation_amount' => $monthlyDepr,
            'accumulated_amount' => $accumulated,
            'book_value' => $bookValue,
            'journal_entry_id' => $journalEntry->id,
            'run_date' => now()->format('Y-m-d'),
        ]);

        Notification::make()
            ->title('Penyusutan berhasil dihitung')
            ->body("Aset: {$asset->name}\nPenyusutan: Rp " . number_format($monthlyDepr, 2) . "\nNilai Buku: Rp " . number_format($bookValue, 2))
            ->success()
            ->send();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFixedAssets::route('/'),
            'create' => Pages\CreateFixedAsset::route('/create'),
            'edit' => Pages\EditFixedAsset::route('/{record}/edit'),
        ];
    }
}
