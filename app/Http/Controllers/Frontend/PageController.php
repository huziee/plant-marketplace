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
        // Dynamic stats from live database models
        $stats = [
            'plants' => \App\Models\Plant::count(),
            'articles' => \App\Models\Post::published()->count(),
            'products' => \App\Models\Product::count(),
            'categories' => \App\Models\PlantCategory::count() + \App\Models\ProductCategory::count(),
        ];

        // Dynamic featured previews
        $featuredPlants = \App\Models\Plant::where('is_featured', true)->latest()->take(4)->get();
        if ($featuredPlants->isEmpty()) {
            $featuredPlants = \App\Models\Plant::latest()->take(4)->get();
        }

        $latestArticles = \App\Models\Post::published()->latest()->take(3)->get();

        $this->seoService->setTitle('About Plantaric — Discover Plants. Grow Knowledge. Embrace Nature.')
                         ->setDescription('Welcome to Plantaric, your online destination for plant discovery, gardening knowledge, botanical care, and plant marketplace.')
                         ->setCanonical(route('frontend.about'));

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'About Us', 'item' => route('frontend.about')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.about', compact('seoService', 'stats', 'featuredPlants', 'latestArticles'));
    }

    public function contact()
    {
        $this->seoService->setTitle('Contact Us — Plantaric Support')
                         ->setDescription('Get in touch with the Plantaric team for order inquiries, plant care questions, partnership opportunities, or feedback.')
                         ->setCanonical(route('frontend.contact'));

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Contact Us', 'item' => route('frontend.contact')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.contact', compact('seoService'));
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

    public function editorialPolicy()
    {
        $this->seoService->setTitle('Editorial Policy | Plantaric')
                         ->setDescription('Learn how Plantaric researches, creates, reviews, and maintains botanical articles, plant care information, and gardening news.')
                         ->setCanonical(route('frontend.editorial-policy'));

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Editorial Policy', 'item' => route('frontend.editorial-policy')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.editorial-policy', compact('seoService'));
    }

    public function privacyPolicy()
    {
        $this->seoService->setTitle('Privacy Policy | Plantaric')
                         ->setDescription('Learn how Plantaric collects, uses, and protects your personal information when shopping for plants, exploring botanical resources, and using our website.')
                         ->setCanonical(route('frontend.privacy'));

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Privacy Policy', 'item' => route('frontend.privacy')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.privacy-policy', compact('seoService'));
    }

    public function terms()
    {
        $this->seoService->setTitle('Terms & Conditions | Plantaric')
                         ->setDescription('Read Plantaric\'s terms and conditions covering website use, botanical content, customer accounts, product purchases, and online shopping.')
                         ->setCanonical(route('frontend.terms'));

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Terms & Conditions', 'item' => route('frontend.terms')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.terms-and-conditions', compact('seoService'));
    }

    public function shippingPolicy()
    {
        $this->seoService->setTitle('Shipping & Delivery Policy | Plantaric')
                         ->setDescription('Learn about Plantaric\'s shipping methods, delivery charges, order processing, live plant packaging, and delivery procedures.')
                         ->setCanonical(route('frontend.shipping-policy'));

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Shipping Policy', 'item' => route('frontend.shipping-policy')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.shipping-policy', compact('seoService'));
    }

    public function returnPolicy()
    {
        $this->seoService->setTitle('Return & Refund Policy | Plantaric')
                         ->setDescription('Understand Plantaric\'s return and refund procedures for plants, gardening products, damaged deliveries, and order cancellations.')
                         ->setCanonical(route('frontend.return-refund-policy'));

        $this->seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Return & Refund Policy', 'item' => route('frontend.return-refund-policy')],
            ],
        ]);

        $seoService = $this->seoService;
        return view('frontend.pages.return-refund-policy', compact('seoService'));
    }

    public function show(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->first();

        if (!$page) {
            $title = ucwords(str_replace('-', ' ', $slug));
            $page = new Page([
                'title' => $title,
                'slug' => $slug,
                'meta_title' => "{$title} — Plantaric",
                'meta_description' => "Read official {$title} guidelines and policies on Plantaric.",
                'status' => 'published',
                'content' => "
                    <h2 class='h4 font-weight-bold mb-3'>{$title}</h2>
                    <p class='lead text-muted mb-4'>Official operational policy and guidelines for Plantaric.</p>
                    <p>Plantaric is committed to maintaining transparency and clear communication with our community of plant lovers, buyers, and partners.</p>
                    <div class='alert alert-info mt-4'>
                        <strong>Need Further Details?</strong> If you have specific questions regarding {$title}, please reach out to our customer support team directly.
                    </div>
                ",
            ]);
            $page->updated_at = now();
        }

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
