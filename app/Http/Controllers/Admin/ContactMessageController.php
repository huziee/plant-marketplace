<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(15)->withQueryString();

        return view('admin.contact_messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }

        return view('admin.contact_messages.show', compact('message'));
    }

    public function updateStatus(Request $request, ContactMessage $message)
    {
        $request->validate(['status' => 'required|string|in:new,read,replied,archived']);
        $message->update(['status' => $request->input('status')]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Message status updated.', 'status' => $message->status]);
        }

        return back()->with('success', 'Message status updated.');
    }

    public function destroy(Request $request, ContactMessage $message)
    {
        $message->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Contact message deleted.']);
        }

        return redirect()->route('admin.contact-messages.index')->with('success', 'Contact message deleted.');
    }
}
