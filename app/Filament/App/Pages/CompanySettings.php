<?php

namespace App\Filament\App\Pages;

use App\Models\Company;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class CompanySettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = '⚙️ Pengaturan';
    protected static ?int $navigationSort = 81;
    protected static ?string $title = 'Perusahaan';

    protected static string $view = 'filament.pages.company-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $company = Company::find(auth()->user()->company_id);

        $this->form->fill($company ? $company->toArray() : []);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('logo')
                    ->label('Logo Perusahaan')
                    ->image()
                    ->directory('company-logos')
                    ->columnSpanFull(),
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Perusahaan'),
                        TextInput::make('code')
                            ->maxLength(255)
                            ->label('Kode'),
                        TextInput::make('npwp')
                            ->maxLength(255)
                            ->label('NPWP'),
                        TextInput::make('nib')
                            ->maxLength(255)
                            ->label('NIB'),
                        Textarea::make('address')
                            ->label('Alamat')
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255)
                            ->label('Telepon'),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->label('Email'),
                        Select::make('timezone')
                            ->options([
                                'Asia/Jakarta' => 'Jakarta (WIB)',
                                'Asia/Makassar' => 'Makassar (WITA)',
                                'Asia/Jayapura' => 'Jayapura (WIT)',
                            ])
                            ->searchable()
                            ->default('Asia/Jakarta')
                            ->label('Timezone'),
                        Select::make('date_format')
                            ->options([
                                'd/m/Y' => 'DD/MM/YYYY (31/12/2024)',
                                'm/d/Y' => 'MM/DD/YYYY (12/31/2024)',
                                'Y-m-d' => 'YYYY-MM-DD (2024-12-31)',
                            ])
                            ->default('d/m/Y')
                            ->label('Format Tanggal'),
                        TextInput::make('fiscal_year_start')
                            ->maxLength(255)
                            ->placeholder('01-01')
                            ->label('Awal Tahun Fiskal (MM-DD)'),
                        TextInput::make('base_currency')
                            ->maxLength(255)
                            ->default('IDR')
                            ->label('Mata Uang Dasar'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $company = Company::find(auth()->user()->company_id);

        if ($company) {
            $company->update($data);
        }

        Notification::make()
            ->title('Pengaturan perusahaan berhasil disimpan')
            ->success()
            ->send();
    }
}
