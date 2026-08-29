<?php

namespace App\Http\Requests;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAuthor();
    }

    public function rules(): array
    {
        $postId = $this->route('post') ? $this->route('post')->id : null;

        return [
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($postId)],
            'type' => ['required', new Enum(PostType::class)],
            'content_category_id' => 'nullable|exists:content_categories,id',
            'author_id' => 'required|exists:users,id',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'featured_image_id' => 'nullable|exists:media,id',
            'status' => ['required', new Enum(PostStatus::class)],
            'is_featured' => 'nullable|boolean',
            'is_editor_pick' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'scheduled_at' => 'nullable|date',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:255',
            'focus_keyword' => 'nullable|string|max:100',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image_id' => 'nullable|exists:media,id',
            'robots_index' => 'nullable|boolean',
            'robots_follow' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'plants' => 'nullable|array',
            'plants.*' => 'exists:plants,id',
            'problems' => 'nullable|array',
            'problems.*' => 'exists:plant_problems,id',
            'related_posts' => 'nullable|array',
            'related_posts.*' => 'exists:posts,id',
        ];
    }
}
