<?php

namespace App\Jobs\ContentAutomation;

use App\Services\ContentAutomation\ArticleDiscoveryService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DiscoverArticlesJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ?int $maxToCreate = null
    ) {}

    public function handle(ArticleDiscoveryService $service): void
    {
        $service->discover($this->maxToCreate);
    }
}
