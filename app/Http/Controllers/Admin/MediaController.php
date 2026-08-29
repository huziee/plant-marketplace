<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadMediaRequest;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%");
            });
        }

        $mediaItems = $query->latest()->paginate(24)->withQueryString();

        return view('admin.media.index', compact('mediaItems'));
    }

    public function store(UploadMediaRequest $request, MediaService $mediaService)
    {
        $uploadedMedia = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $uploadedMedia[] = $mediaService->upload($file, auth()->id());
            }
        } elseif ($request->hasFile('file')) {
            $uploadedMedia[] = $mediaService->upload($request->file('file'), auth()->id());
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Files uploaded successfully', 'media' => $uploadedMedia]);
        }

        return back()->with('success', 'Media uploaded successfully.');
    }

    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $media->update($validated);

        return back()->with('success', 'Media details updated.');
    }

    public function destroy(Media $media, MediaService $mediaService)
    {
        $mediaService->delete($media);

        return back()->with('success', 'Media file deleted successfully.');
    }
}
