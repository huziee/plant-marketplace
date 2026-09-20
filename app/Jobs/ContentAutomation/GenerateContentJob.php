<?php

namespace App\Jobs\ContentAutomation;

use App\Models\ContentCandidate;
use App\Services\ContentAutomation\ContentGenerationService;
use App\Services\ContentAutomation\PostCreationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateContentJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ContentCandidate $candidate
    ) {}

    public function handle(
        ContentGenerationService $generationService,
        PostCreationService $creationService
    ): void {
        $result = $generationService->generate($this->candidate);
        if (!empty($result['success']) && !empty($result['data'])) {
            $creationService->createPost($this->candidate, $result['data']);
        }
    }
}
