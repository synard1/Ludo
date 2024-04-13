<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UploadFileCommand extends Command
{
    protected $signature = 'upload:file {file : The path of the file to upload}';
    protected $description = 'Upload a file to a specific disk';

    public function handle()
    {
        $filePath = $this->argument('file');

        // Check if the file exists
        if (!file_exists($filePath)) {
            $this->error('File not found: ' . $filePath);
            return;
        }

        // Specify the disk you want to upload to (e.g., 's3', 'local', etc.)
        $diskName = 'contabo';

        try {
            // Upload the file to the specified disk
            $uploadedPath = Storage::disk($diskName)->putFile('uploads', $filePath);

            $this->info('File uploaded successfully. Uploaded path: ' . $uploadedPath);
        } catch (\Exception $e) {
            $this->error('Error uploading file: ' . $e->getMessage());
        }
    }
}
