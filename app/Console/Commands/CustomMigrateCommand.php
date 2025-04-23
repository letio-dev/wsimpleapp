<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CustomMigrateCommand extends Command
{
    protected $signature = 'migrate:custom';
    protected $description = 'Run migrations by group: tables, functions, then procedures';

    public function handle()
    {
        $steps = [
            'tables'     => 'Migrating tables...',
            'functions'  => 'Migrating functions...',
            'procedures' => 'Migrating procedures...',
        ];

        foreach ($steps as $folder => $message) {
            $this->info($message);
            Artisan::call('migrate', [
                '--path' => "database/migrations/{$folder}",
                '--force' => true,
            ]);

            $this->line(Artisan::output());
        }

        $this->info('✅ All custom migrations completed.');
    }
}
