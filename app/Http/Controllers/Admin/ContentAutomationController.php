<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCandidate;
use App\Models\ContentTopic;
use App\Models\User;
use App\Services\ContentAutomation\ContentGenerationService;
use App\Services\ContentAutomation\PostCreationService;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class ContentAutomationController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService,
        protected ContentGenerationService $generationService,
        protected PostCreationService $creationService
    ) {}

    public function index(Request $request)
    {
        $query = ContentCandidate::with(['post', 'researchSources'])
            ->latest();

        if ($request->filled('type')) {
            $query->where('content_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('suggested_title', 'like', "%{$s}%")
                  ->orWhere('topic', 'like', "%{$s}%")
                  ->orWhere('fingerprint', 'like', "%{$s}%");
            });
        }

        $candidates = $query->paginate(15)->withQueryString();

        $metrics = [
            'total' => ContentCandidate::count(),
            'discovered' => ContentCandidate::where('status', 'discovered')->count(),
            'ready' => ContentCandidate::where('status', 'ready')->count(),
            'generated' => ContentCandidate::whereIn('status', ['generated', 'published'])->count(),
            'failed' => ContentCandidate::where('status', 'failed')->count(),
            'rejected' => ContentCandidate::where('status', 'rejected')->count(),
        ];

        return view('admin.content-automation.index', compact('candidates', 'metrics'));
    }

    public function show(ContentCandidate $candidate)
    {
        $candidate->load(['post', 'researchSources']);
        return view('admin.content-automation.show', compact('candidate'));
    }

    public function select(ContentCandidate $candidate)
    {
        $candidate->update(['status' => 'ready']);
        return redirect()->back()->with('success', "Candidate #{$candidate->id} marked as ready for generation.");
    }

    public function reject(ContentCandidate $candidate)
    {
        $candidate->update(['status' => 'rejected']);
        return redirect()->back()->with('success', "Candidate #{$candidate->id} rejected.");
    }

    public function generate(ContentCandidate $candidate)
    {
        $result = $this->generationService->generate($candidate);

        if (!empty($result['success']) && !empty($result['data'])) {
            $post = $this->creationService->createPost($candidate, $result['data']);
            return redirect()->route('admin.content-automation.show', $candidate)
                ->with('success', "Post '{$post->title}' created successfully as draft.");
        }

        return redirect()->back()
            ->with('error', "Generation failed: " . ($result['error'] ?? 'Unknown error'));
    }

    public function retry(ContentCandidate $candidate)
    {
        $candidate->update(['status' => 'ready', 'failure_reason' => null]);
        return $this->generate($candidate);
    }

    public function settings()
    {
        $authors = User::whereIn('role', ['admin', 'editor', 'author'])->get();
        $topics = ContentTopic::orderBy('priority', 'desc')->get();

        return view('admin.content-automation.settings', compact('authors', 'topics'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'automation_enabled' => 'nullable|boolean',
            'articles_enabled' => 'nullable|boolean',
            'news_enabled' => 'nullable|boolean',
            'news_per_day' => 'required|integer|min:1|max:20',
            'articles_per_day' => 'required|integer|min:1|max:20',
            'auto_publish' => 'nullable|boolean',
            'default_author_id' => 'required|exists:users,id',
            'openai_model' => 'required|string',
        ]);

        $this->settingsService->set('automation.enabled', !empty($validated['automation_enabled']) ? '1' : '0', 'automation', 'boolean');
        $this->settingsService->set('automation.articles_enabled', !empty($validated['articles_enabled']) ? '1' : '0', 'automation', 'boolean');
        $this->settingsService->set('automation.news_enabled', !empty($validated['news_enabled']) ? '1' : '0', 'automation', 'boolean');
        $this->settingsService->set('automation.news_per_day', (string) $validated['news_per_day'], 'automation', 'integer');
        $this->settingsService->set('automation.articles_per_day', (string) $validated['articles_per_day'], 'automation', 'integer');
        $this->settingsService->set('automation.auto_publish', !empty($validated['auto_publish']) ? '1' : '0', 'automation', 'boolean');
        $this->settingsService->set('automation.default_author_id', (string) $validated['default_author_id'], 'automation', 'integer');
        $this->settingsService->set('automation.openai_model', $validated['openai_model'], 'automation', 'string');

        return redirect()->back()->with('success', 'Content automation settings updated successfully.');
    }

    public function storeTopic(Request $request)
    {
        $validated = $request->validate([
            'content_type' => 'required|in:article,news',
            'topic' => 'required|string|max:255',
            'search_query' => 'required|string|max:255',
            'primary_keyword' => 'nullable|string|max:255',
            'priority' => 'required|integer|min:0|max:100',
        ]);

        ContentTopic::create($validated);

        return redirect()->back()->with('success', 'New content topic added to rotation queue.');
    }

    public function deleteTopic(ContentTopic $topic)
    {
        $topic->delete();
        return redirect()->back()->with('success', 'Topic deleted from rotation queue.');
    }
}
