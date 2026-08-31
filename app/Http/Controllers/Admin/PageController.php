<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('is_system', 'desc')->orderBy('title')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|string|in:published,draft',
            'show_in_footer' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['show_in_footer'] = $request->has('show_in_footer');

        $page = Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', "Page '{$page->title}' created successfully.");
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|string|in:published,draft',
            'show_in_footer' => 'boolean',
        ]);

        if (!$page->is_system && !empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        } else {
            unset($validated['slug']); // Keep original system slug
        }

        $validated['show_in_footer'] = $request->has('show_in_footer');

        $page->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => "Page '{$page->title}' updated successfully."]);
        }

        return redirect()->route('admin.pages.index')->with('success', "Page '{$page->title}' updated successfully.");
    }

    public function destroy(Request $request, Page $page)
    {
        if ($page->is_system) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'System essential trust/legal pages cannot be deleted.'], 403);
            }
            return back()->with('error', 'System essential trust/legal pages cannot be deleted.');
        }

        $page->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => "Page '{$page->title}' deleted successfully."]);
        }

        return redirect()->route('admin.pages.index')->with('success', "Page '{$page->title}' deleted successfully.");
    }
}
