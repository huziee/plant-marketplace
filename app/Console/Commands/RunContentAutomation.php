<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunContentAutomation extends Command
{
    protected $signature = 'content:run';
    protected $description = 'Master content automation runner (Discover News -> Discover Articles -> Generate)';

    public function handle(): int
    {
        $this->info('Starting Master Content Automation Suite...');

        $this->call('content:discover-news');
        $this->call('content:discover-articles');
        $this->call('content:generate');

        $this->info('Master Content Automation Suite finished execution.');

        return Command::SUCCESS;
    }
}
