<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Services\SEO\SeoService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    public function about()
    {
        $page = Page::published()->where('slug', 'about-us')->firstOrFail();

        $this->seoService->setTitle($page->meta_title ?: 'About Us — Plantora')
                         ->setDescription($page->meta_description ?: 'Learn about Plantora, an all-in-one platform combining a plant marketplace, botanical encyclopedia, diagnostic plant doctor, and growing guides.');

        return view('frontend.pages.about', compact('page'));
    }

    public function contact()
    {
        $page = Page::published()->where('slug', 'contact-us')->first();

        $this->seoService->setTitle('Contact Us — Plantora Support')
                         ->setDescription('Get in touch with the Plantora team for order inquiries, plant care questions, partnership opportunities, or feedback.');

        return view('frontend.pages.contact', compact('page'));
    }

    public function submitContact(Request $request)
    {
        // Anti-Spam Honeypot Check: If hidden 'website' field is populated, silently discard
        if ($request->filled('website')) {
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
            }
            return redirect()->back()->with('success', 'Thank you! Your message has been sent.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:5000',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for reaching out! Your message has been received and our team will get back to you shortly.'
            ]);
        }

        return redirect()->back()->with('success', 'Thank you for reaching out! Your message has been received and our team will get back to you shortly.');
    }

    public function show(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        $this->seoService->setTitle($page->meta_title ?: "{$page->title} — Plantora")
                         ->setDescription($page->meta_description ?: "Read the official {$page->title} on Plantora.");

        return view('frontend.pages.show', compact('page'));
    }
}
