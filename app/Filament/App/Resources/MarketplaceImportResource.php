<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\MarketplaceImportResource\Pages;
use App\Models\MarketplaceImport;
use App\Models\Warehouse;
use App\Services\Marketplace\MarketplaceImportService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class MarketplaceImportResource extends Resource
{
    protected static ?string $model = MarketplaceImport::class;

    protected static ?string $navigationGroup = 'Operasional';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 48;
    protected static ?string $modelLabel = 'Import Marketplace';
    protected static ?string $pluralModelLabel = 'Import Marketplace';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('tenant_id'),
                Forms\Components\Hidden::make('company_id'),
                Forms\Components\Select::make('marketplace')
                    ->options([
                        'shopee' => 'Shopee',
                        'tiktok' => 'TikTok Shop',
                        'lazada' => 'Lazada',
                    ])
                    ->required()
                    ->label('Marketplace'),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Gudang'),
                Forms\Components\FileUpload::make('file')
                    ->label('File Excel')
                    ->acceptedFileTypes([
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel',
                        'text/csv',
                    ])
                    ->directory('marketplace-imports')
                    ->preserveFilenames()
                    ->required()
                    ->hiddenOn('edit')
                    ->visible(fn(string $operation): bool => $operation === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('marketplace')
                    ->label('Marketplace')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'shopee' => 'danger',
                        'tiktok' => 'info',
                        'lazada' => 'primary',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('filename')
                    ->label('File')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_orders')
                    ->label('Total Order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('matched_count')
                    ->label('Cocok')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unmatched_count')
                    ->label('Tidak Cocok')
                    ->sortable(),
                Tables\Columns\TextColumn::make('imported_count')
                    ->label('Terimport')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'uploaded' => 'gray',
                        'matched' => 'warning',
                        'previewed' => 'info',
                        'imported' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('imported_at')
                    ->label('Tgl Import')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('marketplace')
                    ->options([
                        'shopee' => 'Shopee',
                        'tiktok' => 'TikTok Shop',
                        'lazada' => 'Lazada',
                    ])
                    ->label('Marketplace'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'uploaded' => 'Uploaded',
                        'matched' => 'Matched',
                        'previewed' => 'Previewed',
                        'imported' => 'Imported',
                        'failed' => 'Failed',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\Action::make('process')
                    ->label('Proses')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn(MarketplaceImport $record): bool => $record->status === 'uploaded')
                    ->action(function (MarketplaceImport $record) {
                        $service = app(MarketplaceImportService::class);
                        $marketplace = $record->marketplace;

                        $orders = collect($record->orders()->with('items')->get());

                        $totalItems = 0;
                        $matched = 0;
                        $unmatched = 0;

                        foreach ($orders as $order) {
                            $items = $order->items;
                            $totalItems += $items->count();

                            foreach ($items as $item) {
                                [$matchedItems, $m, $u] = $service->matchSku(
                                    [[
                                        'marketplace_sku' => $item->marketplace_sku,
                                        'product_name' => $item->product_name,
                                        'variant' => $item->variant,
                                        'quantity' => $item->quantity,
                                        'price' => $item->price,
                                        'discount' => $item->discount,
                                        'total' => $item->total,
                                    ]],
                                    $marketplace
                                );

                                if ($m > 0) {
                                    $item->update([
                                        'match_status' => 'matched',
                                        'internal_sku_id' => $matchedItems[0]['internal_sku_id'] ?? null,
                                    ]);
                                    $matched++;
                                } else {
                                    $unmatched++;
                                }
                            }
                        }

                        $record->update([
                            'matched_count' => $matched,
                            'unmatched_count' => $unmatched,
                            'status' => 'matched',
                        ]);

                        Notification::make()
                            ->title('SKU Matching Selesai')
                            ->body("{$matched} item cocok, {$unmatched} item tidak cocok")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('import')
                    ->label('Import')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(MarketplaceImport $record): bool => in_array($record->status, ['matched', 'previewed']))
                    ->requiresConfirmation()
                    ->action(function (MarketplaceImport $record) {
                        $service = app(MarketplaceImportService::class);

                        $orders = $record->orders()->with('items')->get();
                        $orderData = [];

                        foreach ($orders as $order) {
                            $items = $order->items->map(function ($item) {
                                return [
                                    'marketplace_sku' => $item->marketplace_sku,
                                    'product_name' => $item->product_name,
                                    'variant' => $item->variant,
                                    'quantity' => $item->quantity,
                                    'price' => $item->price,
                                    'discount' => $item->discount,
                                    'total' => $item->total,
                                    'match_status' => $item->match_status,
                                    'internal_sku_id' => $item->internal_sku_id,
                                ];
                            })->toArray();

                            $orderData[] = array_merge($order->toArray(), ['items' => $items]);
                        }

                        [$imported, $errors] = $service->importOrders($orderData, $record->warehouse_id, $record->id);

                        if (!empty($errors)) {
                            Notification::make()
                                ->title('Import dengan beberapa error')
                                ->body("Berhasil: {$imported}, Error: " . count($errors))
                                ->warning()
                                ->send();
                        }

                        $record->update([
                            'imported_count' => $imported,
                            'status' => $imported > 0 ? 'imported' : 'failed',
                            'imported_by' => auth()->id(),
                            'imported_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Import Selesai')
                            ->body("{$imported} order berhasil diimport")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarketplaceImports::route('/'),
            'create' => Pages\CreateMarketplaceImport::route('/create'),
            'edit' => Pages\EditMarketplaceImport::route('/{record}/edit'),
        ];
    }
}
