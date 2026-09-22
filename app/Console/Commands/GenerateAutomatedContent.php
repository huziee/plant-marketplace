<?php

namespace App\Console\Commands;

use App\Models\ContentCandidate;
use App\Services\ContentAutomation\ContentGenerationService;
use App\Services\ContentAutomation\PostCreationService;
use Illuminate\Console\Command;

class GenerateAutomatedContent extends Command
{
    protected $signature = 'content:generate {--id= : Specific candidate ID to generate} {--limit=1 : Maximum candidates to generate}';
    protected $description = 'Generate OpenAI original content for discovered/ready candidates';

    public function handle(
        ContentGenerationService $generationService,
        PostCreationService $creationService
    ): int {
        $candidateId = $this->option('id');
        $limit = (int) $this->option('limit');

        if ($candidateId) {
            $candidates = ContentCandidate::where('id', $candidateId)->get();
        } else {
            $articles = ContentCandidate::where('content_type', 'article')
                ->whereIn('status', ['discovered', 'selected', 'ready'])
                ->orderBy('created_at', 'asc')
                ->take($limit)
                ->get();

            $news = ContentCandidate::where('content_type', 'news')
                ->whereIn('status', ['discovered', 'selected', 'ready'])
                ->orderBy('created_at', 'asc')
                ->take($limit)
                ->get();

            $candidates = $articles->concat($news);
        }

        if ($candidates->isEmpty()) {
            $this->info('No eligible candidates found for content generation.');
            return Command::SUCCESS;
        }

        foreach ($candidates as $candidate) {
            $this->info("Generating content for Candidate #{$candidate->id} ({$candidate->content_type}: {$candidate->suggested_title})...");

            $result = $generationService->generate($candidate);
            if (!empty($result['success']) && !empty($result['data'])) {
                $post = $creationService->createPost($candidate, $result['data']);
                $this->info("Successfully generated Post #{$post->id} ('{$post->title}') as status '{$post->status->value}'.");
            } else {
                $this->error("Failed generating Candidate #{$candidate->id}: " . ($result['error'] ?? 'Unknown error'));
            }
        }

        return Command::SUCCESS;
    }
}
