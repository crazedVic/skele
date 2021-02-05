<?php

namespace Redbastie\Skele\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ScaffoldCommand extends Command
{
    use ManagesFiles;

    protected $signature = 'skele:scaffold';

    public function handle()
    {
        $this->createFiles('install', [
            'DummyAppName' => config('app.name'),
        ]);

        $this->deleteFiles([
            'database/migrations/2014_10_12_000000_create_users_table.php',
            'resources/views/welcome.blade.php',
        ]);

        Artisan::call('skele:migrate', [], $this->getOutput());

        exec('php artisan livewire:publish --config');
        //exec('npm install tailwindcss@latest postcss@latest autoprefixer@latest @tailwindcss/forms -D');
        //exec('npm run dev');

        $this->info('Scaffolding complete! <href=' . config('app.url') . '>' . config('app.url') . '</>');
        $this->info('Remember to run npm install && npm run dev');
    }
}
