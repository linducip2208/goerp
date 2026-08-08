<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'app:backup-database';
    protected $description = 'Backup the database to storage/app/backups';

    public function handle(): int
    {
        $backupDir = storage_path('app/backups');
        File::ensureDirectoryExists($backupDir);

        $filename = 'backup-' . now()->format('Y-m-d_His') . '.sql';
        $filepath = $backupDir . DIRECTORY_SEPARATOR . $filename;

        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $dbName = env('DB_DATABASE', 'goerp');
        $dbUser = env('DB_USERNAME', 'root');
        $dbPass = env('DB_PASSWORD', '');

        $command = sprintf(
            'mysqldump -h%s -P%s -u%s %s %s > "%s"',
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            $dbPass ? '-p' . escapeshellarg($dbPass) : '',
            escapeshellarg($dbName),
            $filepath
        );

        exec($command, $output, $exitCode);

        if ($exitCode !== 0) {
            $this->error('Backup failed. Is mysqldump available in PATH?');
            return self::FAILURE;
        }

        $this->info("Backup created: {$filename}");

        $files = File::files($backupDir);
        $backupFiles = array_filter($files, fn($f) => str_ends_with($f->getFilename(), '.sql'));

        usort($backupFiles, fn($a, $b) => $b->getMTime() <=> $a->getMTime());

        $keep = 7;
        foreach (array_slice($backupFiles, $keep) as $oldFile) {
            File::delete($oldFile->getPathname());
            $this->line("Deleted old backup: {$oldFile->getFilename()}");
        }

        return self::SUCCESS;
    }
}
