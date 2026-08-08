<?php

namespace App\Filament\App\Pages;

use App\Imports\ProductsImport;
use App\Imports\ContactsImport;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;

class DataImport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationGroup = '⚙️ Settings';
    protected static ?int $navigationSort = 86;
    protected static ?string $title = 'Import Data';

    protected static string $view = 'filament.pages.data-import';

    public ?array $data = [];
    public ?array $preview = null;
    public ?array $result = null;

    public function mount(): void
    {
        $this->form->fill([
            'import_type' => null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('import_type')
                    ->label('Tipe Import')
                    ->options([
                        'products' => 'Produk (Product)',
                        'contacts' => 'Kontak (Customer / Supplier)',
                    ])
                    ->required()
                    ->live(),
                FileUpload::make('file')
                    ->label('File Excel')
                    ->acceptedFileTypes([
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel',
                        'text/csv',
                    ])
                    ->directory('imports')
                    ->preserveFilenames()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn () => $this->previewFile()),
            ])
            ->statePath('data');
    }

    public function previewFile(): void
    {
        $filePath = $this->data['file'] ?? null;
        if (!$filePath) {
            $this->preview = null;
            return;
        }

        try {
            $fullPath = storage_path('app/public/' . $filePath);
            if (!file_exists($fullPath)) {
                return;
            }

            $rows = Excel::toArray([], $fullPath)[0] ?? [];
            $this->preview = [
                'headers' => !empty($rows) ? array_keys($rows[0]) : [],
                'rows' => array_slice($rows, 0, 5),
                'total' => count($rows),
            ];
        } catch (\Exception $e) {
            $this->preview = ['error' => $e->getMessage()];
        }
    }

    public function import(): void
    {
        $filePath = $this->data['file'] ?? null;
        $importType = $this->data['import_type'] ?? null;

        if (!$filePath || !$importType) {
            Notification::make()->title('Pilih file dan tipe import')->warning()->send();
            return;
        }

        try {
            $fullPath = storage_path('app/public/' . $filePath);

            if ($importType === 'products') {
                $import = new ProductsImport();
            } else {
                $import = new ContactsImport();
            }

            Excel::import($import, $fullPath);

            $this->result = [
                'imported' => $import->importedCount,
                'skipped' => $import->skippedCount,
                'errors' => $import->errors,
            ];

            Notification::make()
                ->title('Import Selesai')
                ->body("{$this->result['imported']} data berhasil diimpor, {$this->result['skipped']} dilewati.")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Import Gagal')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function downloadTemplate(): ?\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $type = $this->data['import_type'] ?? 'products';
        $templatePath = public_path("templates/{$type}_template.xlsx");

        if (!file_exists($templatePath)) {
            Notification::make()
                ->title('Template belum tersedia')
                ->body("File template untuk {$type} belum dibuat. Silakan buat file Excel dengan format yang sesuai.")
                ->warning()
                ->send();
            return null;
        }

        return response()->download($templatePath);
    }
}
