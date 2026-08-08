<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ContactsImport implements ToCollection, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    public array $importedIds = [];
    public array $skipped = [];
    public array $errors = [];
    public int $importedCount = 0;
    public int $skippedCount = 0;

    public function collection(Collection $rows)
    {
        $tenantId = auth()->user()->tenant_id;
        $companyId = auth()->user()->company_id;

        foreach ($rows as $row) {
            $row = $row->toArray();

            $type = strtolower($row['tipe'] ?? 'customer');
            if (!in_array($type, ['customer', 'supplier', 'employee', 'other'])) {
                $type = 'other';
            }

            $contact = Contact::firstOrCreate(
                ['code' => $row['kode'], 'tenant_id' => $tenantId],
                [
                    'tenant_id' => $tenantId,
                    'company_id' => $companyId,
                    'type' => $type,
                    'name' => $row['nama'],
                    'company_name' => $row['perusahaan'] ?? null,
                    'email' => $row['email'] ?? null,
                    'phone' => $row['telepon'] ?? null,
                    'address' => $row['alamat'] ?? null,
                    'npwp' => $row['npwp'] ?? null,
                    'nik' => $row['nik'] ?? null,
                    'is_active' => true,
                ]
            );

            $this->importedIds[] = $contact->id;
            $this->importedCount++;
        }
    }

    public function rules(): array
    {
        return [
            'kode' => 'required',
            'nama' => 'required',
            'tipe' => 'nullable|in:customer,supplier,employee,other',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
