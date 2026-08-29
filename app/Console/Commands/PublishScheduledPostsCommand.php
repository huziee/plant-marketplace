<?php

namespace App\Console\Commands;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Console\Command;

class PublishScheduledPostsCommand extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Automatically publish posts that have reached their scheduled publishing date and time.';

    public function handle(): int
    {
        $scheduledPosts = Post::where('status', PostStatus::SCHEDULED->value)
            ->where('scheduled_at', '<=', now())
            ->get();

        $count = 0;

        foreach ($scheduledPosts as $post) {
            $post->update([
                'status' => PostStatus::PUBLISHED->value,
                'published_at' => $post->scheduled_at ?? now(),
                'scheduled_at' => null,
            ]);
            $count++;
            $this->info("Published scheduled post ID {$post->id}: '{$post->title}'");
        }

        $this->info("Processed scheduled publishing. Total posts published: {$count}");

        return Command::SUCCESS;
    }
}
