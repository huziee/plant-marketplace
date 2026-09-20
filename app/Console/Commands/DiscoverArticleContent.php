<?php

namespace App\Console\Commands;

use App\Services\ContentAutomation\ArticleDiscoveryService;
use Illuminate\Console\Command;

class DiscoverArticleContent extends Command
{
    protected $signature = 'content:discover-articles {--limit= : Maximum candidates to discover}';
    protected $description = 'Discover article research content candidates from OpenAlex & Plantaric DB';

    public function handle(ArticleDiscoveryService $service): int
    {
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;
        $this->info('Starting OpenAlex article discovery...');

        $created = $service->discover($limit);
        $this->info("Successfully discovered and created {$created} new article candidate(s).");

        return Command::SUCCESS;
    }
}
