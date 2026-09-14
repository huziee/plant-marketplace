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
        $page = Page::published()->where('slug', 'about-us')->first();
        if ($page) {
            $this->seoService->forModel(
                $page,
                'About Us — Plantaric',
                'Learn about Plantaric, an all-in-one platform combining a plant marketplace, botanical encyclopedia, diagnostic plant doctor, and growing guides.'
            )->setCanonical(route('frontend.about'));
        } else {
            $this->seoService->setTitle('About Us — Plantaric')
                             ->setDescription('Learn about Plantaric, an all-in-one platform combining a plant marketplace, botanical encyclopedia, diagnostic plant doctor, and growing guides.')
                             ->setCanonical(route('frontend.about'));
        }

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'About Us', 'item' => route('frontend.about')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.about', compact('page', 'seoService'));
    }

    public function contact()
    {
        $page = Page::published()->where('slug', 'contact-us')->first();

        if ($page) {
            $this->seoService->forModel(
                $page,
                'Contact Us — Plantaric Support',
                'Get in touch with the Plantaric team for order inquiries, plant care questions, partnership opportunities, or feedback.'
            )->setCanonical(route('frontend.contact'));
        } else {
            $this->seoService->setTitle('Contact Us — Plantaric Support')
                             ->setDescription('Get in touch with the Plantaric team for order inquiries, plant care questions, partnership opportunities, or feedback.')
                             ->setCanonical(route('frontend.contact'));
        }

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Contact Us', 'item' => route('frontend.contact')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.contact', compact('page', 'seoService'));
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

        $this->seoService->forModel(
            $page,
            "{$page->title} — Plantaric",
            "Read the official {$page->title} policy documentation on Plantaric."
        )->setCanonical(route('frontend.page.show', $page->slug));

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $page->title, 'item' => route('frontend.page.show', $page->slug)],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.show', compact('page', 'seoService'));
    }
}
