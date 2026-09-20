<?php

namespace App\Console\Commands;

use App\Services\ContentAutomation\NewsDiscoveryService;
use Illuminate\Console\Command;

class DiscoverNewsContent extends Command
{
    protected $signature = 'content:discover-news {--limit= : Maximum candidates to discover}';
    protected $description = 'Discover botanical news content candidates from GDELT';

    public function handle(NewsDiscoveryService $service): int
    {
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;
        $this->info('Starting GDELT news discovery...');

        $created = $service->discover($limit);
        $this->info("Successfully discovered and created {$created} new news candidate(s).");

        return Command::SUCCESS;
    }
}
