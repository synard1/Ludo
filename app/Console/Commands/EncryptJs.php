<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class EncryptJs extends Command
{
    protected $signature = 'encrypt:js {file}';
    protected $description = 'Encrypt and obfuscate a JavaScript file, creating a backup';

    public function handle()
    {
        $file = $this->argument('file');

        // Check if the file exists
        if (!File::exists($file)) {
            $this->error("The specified file '{$file}' does not exist.");
            return;
        }

        // Create a backup of the original file
        $backupFile = $file . '_backup_' . now()->format('YmdHis');
        File::copy($file, $backupFile);
        $this->info("Backup created: {$backupFile}");

        // Read the original content
        $content = File::get($file);

        // Minify the JavaScript content using uglify-js
        $minifiedContent = $this->minifyJs($content);

        // Encrypt the minified JavaScript content
        $encryptedContent = encrypt($minifiedContent);

        // Write the encrypted content back to the file
        File::put($file, $encryptedContent);

        $this->info("JavaScript file encrypted and obfuscated successfully.");
    }

    protected function minifyJs($content)
    {
        // Adjust the path to the uglifyjs binary based on your system
        $uglifyJsPath = '/usr/bin/uglifyjs';

        $process = new Process([$uglifyJsPath, '--mangle', '--compress', 'toplevel']);
        $process->setInput($content);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }
}
