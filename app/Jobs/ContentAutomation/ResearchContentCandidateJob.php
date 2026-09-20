<?php

namespace App\Jobs\ContentAutomation;

use App\Models\ContentCandidate;
use App\Services\ContentAutomation\ResearchContextService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ResearchContentCandidateJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ContentCandidate $candidate
    ) {}

    public function handle(ResearchContextService $service): void
    {
        $service->buildContext($this->candidate);
    }
}
