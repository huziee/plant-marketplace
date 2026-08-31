<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'meta_title' => 'About Plantaric — E-Commerce Plant Marketplace & Botanical Knowledge',
                'meta_description' => 'Learn about Plantaric, an all-in-one platform combining a plant marketplace, botanical encyclopedia, diagnostic plant doctor, and growing guides.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <h2 class="h4 font-weight-bold mb-3">Helping People Grow Better</h2>
                    <p class="lead text-muted mb-4">Plantaric brings reliable botanical information, interactive plant diagnostics, educational growing guides, and a curated e-commerce marketplace together in one unified platform.</p>

                    <hr class="my-4">

                    <h3 class="h5 font-weight-bold mb-3">Our Story</h3>
                    <p>Plantaric was created to make plant care and botanical commerce straightforward for everyone. Many plant enthusiasts struggle with conflicting advice, unidentifiable leaf issues, or difficulty finding healthy plants suited to their specific home environments. Plantaric bridges this gap by offering a single, trustworthy space to discover plants, learn proper care routines, diagnose problem symptoms, and shop quality botanical supplies.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-3">What Plantaric Offers</h3>
                    <div class="row g-3 my-2">
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light">
                                <h4 class="h6 font-weight-bold text-success mb-2">🌿 Plant Marketplace</h4>
                                <p class="small text-muted mb-0">Discover healthy nursery-grown plants, textured ceramic pots, organic soil mixes, fertilizers, and essential gardening tools.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light">
                                <h4 class="h6 font-weight-bold text-success mb-2">📖 Botanical Encyclopedia</h4>
                                <p class="small text-muted mb-0">Explore detailed plant species directories complete with scientific taxonomy, light & watering matrices, soil pH, humidity, and pet toxicity alerts.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light">
                                <h4 class="h6 font-weight-bold text-success mb-2">🩺 Plant Doctor</h4>
                                <p class="small text-muted mb-0">Diagnostic symptom lookup for plant diseases, leaf discoloration, fungal spots, pests, root rot, and cultural growth stress.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light">
                                <h4 class="h6 font-weight-bold text-success mb-2">📚 Articles & Guides</h4>
                                <p class="small text-muted mb-0">Step-by-step growing tutorials, seasonal care calendars, and expert horticultural advice written by plant specialists.</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="h5 font-weight-bold mt-4 mb-3">Our Mission</h3>
                    <blockquote class="p-3 bg-light border-start border-4 border-success fst-italic my-3">
                        "To make botanical knowledge easier to understand, empower growers with diagnostic tools, and help plant lovers make confident, informed decisions for their indoor and outdoor gardens."
                    </blockquote>

                    <div class="alert alert-info mt-4">
                        <strong>Important Note:</strong> Plantaric is designed to provide general educational information and care guidance. Our content and diagnostic tools are not intended to replace professional agricultural extension services, commercial veterinary care, or certified pesticide advice.
                    </div>
                ',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'meta_title' => 'Contact Plantaric Support & Customer Service',
                'meta_description' => 'Get in touch with the Plantaric team for order inquiries, plant care questions, partnership opportunities, or feedback.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '<p>Contact form and customer support information.</p>',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'meta_title' => 'Privacy Policy — Plantaric',
                'meta_description' => 'Read how Plantaric collects, uses, protects, and handles your personal information, account data, and browsing security.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small">Last Updated: ' . date('F d, Y') . '</p>
                    <p>At Plantaric, accessible from ' . url('/') . ', one of our main priorities is the privacy of our visitors and registered users. This Privacy Policy document outlines the types of information collected and recorded by Plantaric and how we use it.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Information We Collect</h3>
                    <p>We collect information to provide better services, process orders, and personalize your experience. This includes:</p>
                    <ul>
                        <li><strong>Account & Order Data:</strong> Name, email address, shipping address, billing address, phone number, and password credentials when creating an account or placing an order.</li>
                        <li><strong>Contact & Newsletter Inquiries:</strong> Information submitted via contact forms, newsletter subscription inputs, or customer support inquiries.</li>
                        <li><strong>User Content:</strong> Ratings, product reviews, plant questions, or feedback posted on the platform.</li>
                        <li><strong>Usage & Technical Data:</strong> IP address, browser type, device information, operating system, and pages visited collected automatically via server logs and cookies.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. How Information Is Used</h3>
                    <p>Plantaric uses the collected data for the following legitimate business purposes:</p>
                    <ul>
                        <li>Fulfilling, shipping, and managing customer orders and payment transactions.</li>
                        <li>Providing customer account management, wishlist saving, and plant diagnosis services.</li>
                        <li>Sending order confirmations, shipping updates, and optional email newsletters (where subscribed).</li>
                        <li>Improving website performance, security, SEO, and user navigation experience.</li>
                        <li>Preventing fraudulent activities and complying with legal obligations.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Cookies & Tracking Technologies</h3>
                    <p>Plantaric uses cookies and similar session management technologies to maintain cart state, keep users logged in, remember preferences, and gather general website traffic analytics. You can manage or disable cookies through your web browser settings.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Third-Party Advertising & Google AdSense</h3>
                    <p>Third-party vendors, including Google where enabled, may use cookies or device identifiers to serve and measure advertisements based on a user’s prior visits to Plantaric or other websites. Users may opt out of personalized advertising by visiting Google Advertising Settings or third-party opt-out portals.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Analytics & Service Providers</h3>
                    <p>We may share necessary data with trusted third-party service providers (such as payment processing gateways, shipping couriers, and hosting providers) strictly to perform operational functions on our behalf. These parties are contractually obligated to protect your data.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. Data Security & Retention</h3>
                    <p>We employ standard technical safeguards, including HTTPS encryption, CSRF protection, and secure hashed password storage, to safeguard your personal data. We retain personal data for as long as necessary to fulfill orders and satisfy legal accounting requirements.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">7. User Rights & Choices</h3>
                    <p>You have the right to access, update, or request deletion of your personal account information at any time by logging into your Account Dashboard or contacting Plantaric support.</p>
                ',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'meta_title' => 'Terms & Conditions — Plantaric',
                'meta_description' => 'Terms of service, account responsibilities, order policies, intellectual property, and acceptable usage guidelines for Plantaric.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small">Last Updated: ' . date('F d, Y') . '</p>
                    <p>Welcome to Plantaric. By accessing or using our website, mobile interface, or purchasing products, you agree to be bound by these Terms & Conditions. Please read them carefully.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Account Responsibilities</h3>
                    <p>When you create an account at Plantaric, you are responsible for maintaining the confidentiality of your login credentials and for restricting access to your computer or device. You agree to accept responsibility for all activities that occur under your account.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. E-Commerce & Product Pricing</h3>
                    <p>We make every effort to display plant species, pot variations, availability, and prices accurately. However, prices and product availability are subject to change without notice. In the event of a pricing or typographic error, Plantaric reserves the right to cancel or refuse any orders placed for that product.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Orders, Payments & Cancellations</h3>
                    <p>An order confirmation does not signify our final acceptance of an order. We reserve the right to accept or decline any order for any reason, including inventory shortages, suspected fraud, or shipping restrictions for perishable live plants.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. User-Generated Content & Reviews</h3>
                    <p>Users may post reviews, plant photos, and comments provided the content is not illegal, defamatory, threatening, or infringing upon intellectual property. Plantaric reserves the right to moderate, edit, or remove any user submission.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Intellectual Property</h3>
                    <p>All content included on Plantaric, such as article text, botanical encyclopedia care matrices, logos, custom graphics, icon designs, and software code, is the property of Plantaric and protected by international copyright laws.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. Limitation of Liability</h3>
                    <p>Plantaric provides content and products "as is" without warranty of any kind. Plantaric shall not be liable for any indirect, incidental, or consequential damages resulting from the use of our platform or plant care guidance.</p>
                ',
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'meta_title' => 'Cookie Policy — Plantaric',
                'meta_description' => 'Understand how Plantaric uses cookies, session management, analytics, and consent choices.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small">Last Updated: ' . date('F d, Y') . '</p>
                    <p>This Cookie Policy explains how Plantaric uses cookies and similar tracking technologies to recognize you when you visit our website.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. What Are Cookies?</h3>
                    <p>Cookies are small text files placed on your computer or mobile device when you visit a website. They are widely used to make websites work efficiently and provide report analytics.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Cookie Categories We Use</h3>
                    <ul>
                        <li><strong>Essential Cookies:</strong> Required for technical operation, user authentication, security CSRF protection, and cart drawer persistence.</li>
                        <li><strong>Preference Cookies:</strong> Allow Plantaric to remember user selections, such as default currency or saved shipping filters.</li>
                        <li><strong>Analytics Cookies:</strong> Help us measure visitor engagement, popular botanical guides, and site traffic patterns where enabled.</li>
                        <li><strong>Advertising Cookies:</strong> Used by third-party advertising partners (such as Google AdSense where configured) to serve relevant promotions.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Managing Cookie Choices</h3>
                    <p>You can manage your cookie preferences through your web browser settings. Disabling essential cookies may impair your ability to add items to your shopping cart or complete checkout.</p>
                ',
            ],
            [
                'title' => 'Plant Care Disclaimer',
                'slug' => 'disclaimer',
                'meta_title' => 'Plant Care & Botanical Disclaimer — Plantaric',
                'meta_description' => 'Important educational disclaimer regarding Plantaric care advice, diagnostic plant doctor results, chemical treatment rules, and pet toxicity.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <div class="alert alert-warning mb-4">
                        <strong>Educational Notice:</strong> The information provided on Plantaric, including botanical encyclopedia entries, Plant Doctor diagnostic guides, and care articles, is published strictly for general educational and informational purposes.
                    </div>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Growth Conditions & Variability</h3>
                    <p>Plant growth, health, flowering, and leaf appearance depend on diverse micro-climates, light intensity, tap water mineral composition, humidity levels, seasonal temperatures, and soil aeration. Care guidelines provide generalized parameters and cannot guarantee identical growth outcomes in every home.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Plant Doctor Diagnostic Guidance</h3>
                    <p>The Plant Doctor diagnostic lookup provides automated symptom-to-cause matching based on reported plant leaf conditions. It is intended to assist plant owners in identifying potential issues, but does not constitute an infallible laboratory diagnosis.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Chemical & Fertilizer Safety</h3>
                    <p>When applying pesticides, fungicides, neem oil remedies, or chemical fertilizers mentioned in care guides:</p>
                    <ul>
                        <li>Always read and strictly adhere to the manufacturer label instructions.</li>
                        <li>Follow local municipal and environmental regulations regarding pesticide usage.</li>
                        <li>Test sprays on a small leaf area before treating an entire plant.</li>
                        <li>Wear protective equipment and apply chemicals in well-ventilated areas.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Pet & Child Toxicity Advisory</h3>
                    <p>Plant toxicity ratings provided on Plantaric are educational summaries based on standard botanical references. In case of accidental ingestion by pets or children, immediately contact a licensed veterinarian, medical doctor, or regional poison control emergency center.</p>
                ',
            ],
            [
                'title' => 'Editorial Policy',
                'slug' => 'editorial-policy',
                'meta_title' => 'Editorial & Content Publishing Policy — Plantaric',
                'meta_description' => 'Learn about Plantaric’s standards for botanical research, citation of sources, human review, AI assistance disclosure, and content updates.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <h3 class="h5 font-weight-bold mb-2">1. Our Editorial Standards</h3>
                    <p>Plantaric is committed to publishing accurate, easy-to-understand, and practical botanical content. Our articles, step-by-step growing tutorials, and plant species profiles are written and structured to help growers of all skill levels succeed.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Research & Citation</h3>
                    <p>Our editorial team references botanical taxonomy guides, agricultural extension resources, academic research, and trusted industry literature. Where applicable, cited sources are listed in the references section of our articles.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. AI-Assisted Content Disclosure</h3>
                    <p>To assist with structural formatting, research compilation, and language refinement, Plantaric editorial staff may utilize artificial intelligence tools. However, all published articles, encyclopedia entries, and care recommendations undergo human editorial review prior to publication.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Corrections & Content Updates</h3>
                    <p>Botanical science and plant availability evolve. When factual errors or outdated care practices are identified, our team promptly updates the published material to maintain content accuracy.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Editorial Independence</h3>
                    <p>Commercial relationships, product placements, or potential advertising revenue do not dictate our editorial conclusions or plant health ratings.</p>
                ',
            ],
            [
                'title' => 'Shipping Policy',
                'slug' => 'shipping-policy',
                'meta_title' => 'Shipping & Delivery Policy — Plantaric Marketplace',
                'meta_description' => 'Information regarding plant delivery methods, packaging for live plants, rates, thresholds, and fulfillment timelines.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <h3 class="h5 font-weight-bold mb-2">1. Live Plant Delivery</h3>
                    <p>Shipping live potted plants requires careful packaging to preserve root systems and foliage. Plantaric works with nursery fulfillment partners to ensure plants are secured in protective, insulated, moisture-retaining shipping containers.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Rates & Thresholds</h3>
                    <p>Shipping options and calculated rates depend on your shipping destination, total package weight, and delivery method selected during checkout. Orders exceeding our free shipping threshold (e.g. $75) qualify for free standard ground delivery.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Processing & Handling Times</h3>
                    <p>Standard order processing requires 1–3 business days prior to carrier dispatch. During extreme weather conditions (severe cold or heatwaves), dispatches may be temporarily paused to prevent plant damage in transit.</p>
                ',
            ],
            [
                'title' => 'Return & Refund Policy',
                'slug' => 'return-refund-policy',
                'meta_title' => 'Return & Refund Policy — Plantaric Guarantee',
                'meta_description' => 'Details on our plant guarantee, returns eligibility, damaged plant replacements, and refund procedure.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <h3 class="h5 font-weight-bold mb-2">1. 30-Day Healthy Plant Guarantee</h3>
                    <p>We take pride in delivering healthy plants. If your plant arrives damaged or in poor health, contact our support team within 30 days of arrival with photos of the plant and box, and we will issue a replacement or refund.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Return Eligibility</h3>
                    <p>Non-perishable items such as pots, tools, and unopened fertilizers may be returned within 30 days of receipt provided they are unused and in original packaging.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Refund Processing</h3>
                    <p>Once your return is received or damaged plant submission is verified, approved refunds are processed back to your original payment method within 3–7 business days.</p>
                ',
            ],
            [
                'title' => 'Advertising & Affiliate Disclosure',
                'slug' => 'advertising-disclosure',
                'meta_title' => 'Advertising & Affiliate Disclosure — Plantaric',
                'meta_description' => 'Transparency statement regarding third-party advertising, sponsored content, and potential affiliate relationships.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <h3 class="h5 font-weight-bold mb-2">1. Transparency & Monetization</h3>
                    <p>Plantaric is a self-funded publication and e-commerce marketplace. To support our free botanical encyclopedia, plant doctor diagnostic tool, and educational guides, we may display third-party advertisements (such as Google AdSense where enabled) or feature sponsored products.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Affiliate Links</h3>
                    <p>Some links to gardening tools, soils, or supplies on Plantaric may contain affiliate tracking codes. If you purchase an item through an affiliate link, Plantaric may earn a small commission at no additional cost to you.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Product Endorsements</h3>
                    <p>The inclusion of advertisements or affiliate recommendations does not constitute a formal guarantee of product quality. We select recommended tools based on botanical utility.</p>
                ',
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
