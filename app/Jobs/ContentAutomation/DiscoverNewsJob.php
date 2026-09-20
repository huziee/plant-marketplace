<?php

namespace App\Jobs\ContentAutomation;

use App\Services\ContentAutomation\NewsDiscoveryService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DiscoverNewsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ?int $maxToCreate = null
    ) {}

    public function handle(NewsDiscoveryService $service): void
    {
        $service->discover($this->maxToCreate);
    }
}
