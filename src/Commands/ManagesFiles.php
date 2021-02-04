<?php

namespace Redbastie\Skele\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

trait ManagesFiles
{
    private $filesystem;

    private function filesystem()
    {
        if (!$this->filesystem) {
            $this->filesystem = new Filesystem;
        }

        return $this->filesystem;
    }

    protected function createFiles($stubFolder, $replaces = [])
    {
        foreach ($this->filesystem()->allFiles(__DIR__ . '/../../resources/stubs/' . $stubFolder) as $file) {
            $filePath = Str::replaceLast('.stub', '', $this->replace($replaces, $file->getRelativePathname()));

            if ($fileDir = implode(DIRECTORY_SEPARATOR , array_slice(explode(DIRECTORY_SEPARATOR , $filePath), 0, -1))) {
                $this->filesystem()->ensureDirectoryExists($fileDir);
            }
            // prevent override by default
            if (!$this->filesystem()->exists($filePath)) {
                $this->filesystem()->put($filePath, $this->replace($replaces, $file->getContents()));
                $this->info('Created file: <info>' . $filePath . '</info>');
            }
            else{
                 $this->warn('Unable to create file: <info>' . $filePath . '</info>. File already exists.  Use --force to override.');
            }
        }
    }
    
    protected function appendFiles($stubFolder, $replaces=[], $file, $string)
    {
        $filePath = Str::replaceLast('.stub', '', $this->replace($replaces, $file->getRelativePathname()));

        // make sure file exists
        if (!$this->filesystem()->exists($filePath)) {
            $this->filesystem()->append($filePath, $this->replace($replaces, $file->getContents()));
            $this->info('Updated file: <info>' . $filePath . '</info>');
        }
        else{
             $this->error('Unable to find file: <info>' . $filePath . '</info>. File was not updated.');
        }
        
    }

    protected function deleteFiles($filePaths)
    {
        foreach ($filePaths as $filePath) {
            if ($this->fileExists($filePath)) {
                $this->filesystem()->delete($filePath);
                $this->warn('Deleted file: <info>' . $filePath . '</info>');
            }
        }
    }

    protected function fileExists($filePath)
    {
        return $this->filesystem()->exists($filePath);
    }

    private function replace($replaces, $contents)
    {
        foreach ($replaces as $search => $replace) {
            $contents = str_replace($search, $replace, $contents);
        }

        return $contents;
    }
}
