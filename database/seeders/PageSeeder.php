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
                'meta_description' => 'Learn about Plantaric, an all-in-one platform combining a plant marketplace, botanical encyclopedia, and growing guides.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <h2 class="h4 font-weight-bold mb-3">Helping People Grow Better</h2>
                    <p class="lead text-muted mb-4">Plantaric brings reliable botanical information, interactive plant health care guides, educational growing guides, and a curated e-commerce marketplace together in one unified platform.</p>

                    <hr class="my-4">

                    <h3 class="h5 font-weight-bold mb-3">Our Story</h3>
                    <p>Plantaric was created to make plant care and botanical commerce straightforward for everyone. Many plant enthusiasts struggle with conflicting advice, unidentifiable leaf issues, or difficulty finding healthy plants suited to their specific home environments. Plantaric bridges this gap by offering a single, trustworthy space to discover plants, learn proper care routines, troubleshoot problem symptoms, and shop quality botanical supplies.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-3">What Plantaric Offers</h3>
                    <div class="row g-3 my-2">
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light">
                                <h4 class="h6 font-weight-bold text-success mb-2">🌿 Plant Marketplace</h4>
                                <p class="small text-muted mb-0">Discover healthy plants, textured ceramic pots, organic soil mixes, fertilizers, and essential gardening tools.</p>
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
                                <h4 class="h6 font-weight-bold text-success mb-2">🌱 Care & Troubleshooting</h4>
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
                        "To make botanical knowledge easier to understand, empower growers with diagnostic care tools, and help plant lovers make confident, informed decisions for their indoor and outdoor gardens."
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
                'meta_title' => 'Privacy Policy | Plantaric',
                'meta_description' => 'Learn how Plantaric collects, uses, and protects your personal information when shopping for plants, exploring botanical resources, and using our website.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small mb-4">Last Updated: September 20, 2026</p>
                    
                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Introduction</h3>
                    <p>Welcome to <strong>Plantaric</strong>. At Plantaric, we respect your privacy and are committed to protecting the personal information you share with us. Our platform provides botanical information, plant care resources, gardening articles, plant health troubleshooting, and an online marketplace for plants and gardening products.</p>
                    <p>This Privacy Policy explains how we collect, use, store, and protect your information when you visit our website, register an account, make a purchase, subscribe to our newsletter, or interact with our services. By using Plantaric, you acknowledge the data practices described in this policy.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Information We Collect</h3>
                    <p>Depending on how you interact with Plantaric, we may collect the following information:</p>
                    <ul>
                        <li><strong>Personal Information:</strong> Full name, email address, phone number, billing and shipping addresses, account registration details, order and transaction information, and customer support messages.</li>
                        <li><strong>Account Information:</strong> Encrypted or securely hashed authentication credentials, saved addresses, order history, wishlist items, and submitted reviews.</li>
                        <li><strong>Technical Information:</strong> IP address, browser type, operating system, device information, pages visited, and referring website URLs.</li>
                        <li><strong>Newsletter Information:</strong> Email address for sending botanical updates, plant care articles, gardening news, and promotional communications. You may unsubscribe at any time using the unsubscribe link provided in marketing emails.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. How We Use Your Information</h3>
                    <p>We use collected information to:</p>
                    <ul>
                        <li>Provide and maintain Plantaric\'s services and customer accounts.</li>
                        <li>Process purchases, manage orders, and arrange product deliveries.</li>
                        <li>Respond to customer inquiries and maintain cart and wishlist data.</li>
                        <li>Manage customer reviews, ratings, and send requested newsletters.</li>
                        <li>Improve website functionality, user experience, and detect fraudulent or unauthorized activity.</li>
                        <li>Comply with applicable legal obligations.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Google AdSense and Third-Party Advertising</h3>
                    <p>Plantaric may display advertisements through Google AdSense and other advertising partners. Third-party vendors, including Google, may use cookies to serve advertisements based on users\' previous visits to Plantaric or other websites.</p>
                    <p>Google\'s use of advertising cookies enables Google and its partners to serve advertisements based on visits to websites and other online activity. Users can manage or opt out of personalized Google advertising through <a href="https://myadcenter.google.com/" target="_blank" rel="noopener">Google\'s My Ad Center</a>. Additional information about how Google uses data from partner websites is available through <a href="https://policies.google.com/technologies/partner-sites" target="_blank" rel="noopener">Google\'s Privacy & Terms</a>.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Artificial Intelligence and Content Automation</h3>
                    <p>Plantaric uses AI-assisted technology to support the creation and organization of botanical information, gardening articles, and news content. Our content automation system processes publicly available research information and news material to help prepare educational publications. We do not treat the automated generation of editorial content as permission to disclose private customer information.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. Sharing Information with Third Parties</h3>
                    <p>We may share necessary data with trusted service providers (payment processors, shipping couriers, hosting providers, email delivery services, and advertising or analytics partners) strictly to perform operational functions on our behalf. We do not sell customer contact lists to third-party advertisers.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">7. Cookies and Tracking Technologies</h3>
                    <p>Plantaric uses cookies and similar session technologies to support website functionality, maintain login sessions, preserve cart contents, store user preferences, measure performance, and support advertising. Please review our <a href="' . route('frontend.cookie-policy') . '">Cookie Policy</a> for detailed information.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">8. Data Security & Retention</h3>
                    <p>We implement standard technical and organizational safeguards (HTTPS encryption, CSRF protection, secure hashed passwords) designed to protect personal information. We retain personal data for as long as necessary to provide our services, fulfill transactions, maintain business records, and satisfy legal accounting requirements.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">9. Your Privacy Rights</h3>
                    <p>Depending on applicable law, you may have rights to request access to, correction of, deletion of, or restrictions on the processing of your personal information. To submit a privacy-related request, please contact us at <a href="mailto:privacy@plantaric.com">privacy@plantaric.com</a>.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">10. Contact Information</h3>
                    <p>For questions regarding this Privacy Policy, please contact:</p>
                    <p class="mb-0"><strong>Plantaric Support Team</strong><br>Website: <a href="https://plantaric.com">plantaric.com</a><br>Email: <a href="mailto:privacy@plantaric.com">privacy@plantaric.com</a></p>
                ',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'meta_title' => 'Terms & Conditions | Plantaric',
                'meta_description' => 'Read Plantaric\'s terms and conditions covering website use, botanical content, customer accounts, product purchases, and online shopping.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small mb-4">Last Updated: September 20, 2026</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Introduction</h3>
                    <p>Welcome to <strong>Plantaric</strong>. These Terms & Conditions govern your use of the Plantaric website and its associated services. Plantaric provides an online plant marketplace, botanical encyclopedia, plant care information, educational articles, gardening news, and related resources. By accessing or using our website, you agree to comply with these Terms & Conditions. If you do not agree, please discontinue use of the website.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Eligibility and User Accounts</h3>
                    <p>Users may browse Plantaric\'s publicly available educational content without registering an account. Certain features—including placing orders, managing wishlists, submitting product reviews, and accessing order history—require account registration. Users agree to provide accurate registration information and maintain account security.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Botanical and Educational Content</h3>
                    <p>Plantaric provides botanical information for educational and informational purposes. Our content includes plant identification, scientific classification, watering recommendations, sunlight requirements, soil information, seasonal maintenance, and plant health troubleshooting. Individual plant requirements may vary depending on climate and micro-environment. Please review our <a href="' . route('frontend.disclaimer') . '">Plant Care Disclaimer</a> for additional details.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Product Listings</h3>
                    <p>Plantaric offers plants, seeds, gardening accessories, pots, and related products for purchase. Living plants naturally vary in appearance, size, leaf patterns, and color. Some product illustrations may be digitally produced or AI-assisted; such images should not be interpreted as a guarantee of the exact appearance of the delivered plant.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Orders and Payments</h3>
                    <p>Customers are responsible for reviewing their orders before completing checkout. Order placement is subject to payment confirmation, product availability, delivery eligibility, and verification procedures. An automatically generated order confirmation does not guarantee final order acceptance.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. Product Prices and Promotions</h3>
                    <p>Product prices and promotional offers are displayed on our website. Discount coupons may be subject to expiration dates, minimum order values, usage restrictions, and other stated conditions. All shipping charges and applicable fees are disclosed during checkout.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">7. Customer Reviews</h3>
                    <p>Registered customers may submit product ratings and reviews. Reviews must reflect genuine experiences and must not contain misleading, abusive, or unlawful content. Plantaric reserves the right to moderate or remove reviews that violate these standards.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">8. Intellectual Property</h3>
                    <p>The Plantaric name, branding, website design, original written material, care matrices, custom graphics, and software code are protected by applicable intellectual property laws. Unauthorized republication or commercial redistribution is prohibited.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">9. AI-Assisted Content</h3>
                    <p>Some educational articles, botanical illustrations, and informational resources may be created with the assistance of artificial intelligence. AI-assisted content is provided for informational purposes and may require independent verification.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">10. Prohibited Activities</h3>
                    <p>Users must not attempt to compromise website security, access other users\' accounts, submit fraudulent orders or reviews, distribute malware, engage in spam, or interfere with normal website operations.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">11. Contact</h3>
                    <p>For questions regarding these Terms & Conditions, contact:</p>
                    <p class="mb-0"><strong>Plantaric Legal Team</strong><br>Email: <a href="mailto:support@plantaric.com">support@plantaric.com</a><br>Website: <a href="https://plantaric.com">plantaric.com</a></p>
                ',
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'meta_title' => 'Cookie Policy | Plantaric',
                'meta_description' => 'Learn how Plantaric uses cookies to support shopping, website functionality, preferences, analytics, and advertisements.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small mb-4">Last Updated: September 20, 2026</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Introduction</h3>
                    <p>Plantaric uses cookies and similar technologies to provide website functionality, improve user experience, and support selected third-party services. This Cookie Policy explains what cookies are, how they are used, and how visitors can manage their preferences.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. What Are Cookies?</h3>
                    <p>Cookies are small text files stored on your device when you visit a website. They help websites remember information such as login sessions, shopping cart contents, and user preferences.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Essential Cookies</h3>
                    <p>Essential cookies support core website functionality, such as maintaining secure login sessions, preserving shopping cart contents, processing checkout requests, and protecting against CSRF security threats. Disabling essential cookies may prevent some features from functioning correctly.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Preference & Analytics Cookies</h3>
                    <p>Preference cookies remember user-selected settings (e.g. shipping filters or currency choices). Analytics cookies help us measure visitor engagement, page views, and site performance to continuously improve user experience.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Advertising Cookies</h3>
                    <p>Plantaric may use Google AdSense and other advertising services to display advertisements. Google and its advertising partners may use cookies to serve advertisements and measure campaign performance. Visitors can manage personalized Google advertising through <a href="https://myadcenter.google.com/" target="_blank" rel="noopener">Google\'s My Ad Center</a>.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. Managing Cookie Preferences</h3>
                    <p>You can manage or disable cookies through your web browser settings and cookie consent banners. Rejecting optional cookies will not prevent access to publicly available botanical resources.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">7. Contact</h3>
                    <p>For questions about our use of cookies, email us at <a href="mailto:privacy@plantaric.com">privacy@plantaric.com</a>.</p>
                ',
            ],
            [
                'title' => 'Plant Care Disclaimer',
                'slug' => 'disclaimer',
                'meta_title' => 'Plant Care Disclaimer | Plantaric',
                'meta_description' => 'Understand the educational nature of Plantaric\'s botanical information, plant care recommendations, and plant health troubleshooting resources.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small mb-4">Last Updated: September 20, 2026</p>

                    <div class="alert alert-warning mb-4">
                        <strong>Educational Notice:</strong> The information provided on Plantaric—including botanical encyclopedia entries, troubleshooting care guides, and botanical articles—is published strictly for general educational and informational purposes.
                    </div>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Educational Purpose</h3>
                    <p>Plantaric provides botanical information, plant care guidance, and gardening resources for general educational purposes. Our platform is designed to help users understand plant characteristics, growing environments, maintenance requirements, and common health problems. The information provided does not guarantee specific plant growth, recovery, or survival outcomes.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Plant Care Recommendations</h3>
                    <p>Recommendations concerning watering, sunlight, humidity, temperature, soil composition, fertilization, and repotting are general parameters. Individual plant requirements may differ depending on climate, season, soil conditions, container size, plant maturity, and indoor environment.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Plant Health and Troubleshooting</h3>
                    <p>Plantaric\'s Botanical Encyclopedia includes diagnostic information for common plant issues (yellowing leaves, browning, wilting, pest infestations, fungal spots, and root damage). Suggested causes and remedies are intended to assist plant owners in identifying potential problems, but do not constitute an infallible laboratory diagnosis.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Plant Toxicity and Safety</h3>
                    <p>Some plants may be toxic to pets, children, or adults if ingested or improperly handled. Toxicity ratings are educational summaries based on standard botanical references. If a person or animal is suspected of ingesting a harmful plant, seek appropriate medical or veterinary assistance immediately.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Pest Control and Chemical Treatments</h3>
                    <p>When applying pesticides, fungicides, neem oil remedies, or chemical fertilizers mentioned in care guides, users should carefully read manufacturer label instructions and follow local environmental regulations.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. AI-Assisted Botanical Information</h3>
                    <p>Certain illustrations and educational materials may be prepared with the assistance of artificial intelligence. Users should independently verify information when making decisions involving safety-sensitive matters.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">7. Contact</h3>
                    <p>For questions regarding our botanical disclaimer, contact <a href="mailto:support@plantaric.com">support@plantaric.com</a>.</p>
                ',
            ],
            [
                'title' => 'Editorial Policy',
                'slug' => 'editorial-policy',
                'meta_title' => 'Editorial Policy | Plantaric',
                'meta_description' => 'Learn how Plantaric researches, creates, reviews, and maintains botanical articles, plant care information, and gardening news.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small mb-4">Last Updated: September 20, 2026</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Our Editorial Mission</h3>
                    <p>Plantaric aims to make botanical knowledge accessible, practical, and understandable. Through our Botanical Encyclopedia, educational articles, gardening news, and plant health resources, we help readers develop a better understanding of plants and their care.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Content Categories</h3>
                    <ul>
                        <li><strong>Botanical Encyclopedia:</strong> Information about plant species, scientific classification, native origins, care requirements, and seasonal maintenance.</li>
                        <li><strong>Plant Health & Troubleshooting:</strong> Educational resources covering plant symptoms, possible causes, and care adjustments or treatment methods.</li>
                        <li><strong>Botanical Articles:</strong> Informational content about plant science, gardening practices, and environmental conditions.</li>
                        <li><strong>Gardening & Botanical News:</strong> Coverage of developments in horticulture, botanical research, and plant-related industries.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Research and Sources</h3>
                    <p>Plantaric uses scientific publications, botanical databases, academic research, and trusted industry resources to support its editorial content. Cited sources are listed in the reference sections of research publications.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. AI-Assisted Content Creation</h3>
                    <p>Plantaric uses artificial intelligence to support selected editorial workflows (research discovery, information organization, article structuring, and draft preparation). Our editorial standards prioritize human checks and quality assurance prior to publishing.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Editorial Review and Accuracy</h3>
                    <p>All published articles and care matrices undergo editorial review for accuracy, clarity, and practical utility. Content involving toxicity ratings or chemical safety warrants additional verification.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. Advertising & Editorial Independence</h3>
                    <p>Commercial relationships, product sales, or advertising revenues do not dictate our editorial conclusions or plant care parameters. Sponsored content is clearly identified where applicable.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">7. Contact</h3>
                    <p>For editorial questions or feedback, email <a href="mailto:editorial@plantaric.com">editorial@plantaric.com</a>.</p>
                ',
            ],
            [
                'title' => 'Shipping Policy',
                'slug' => 'shipping-policy',
                'meta_title' => 'Shipping & Delivery Policy | Plantaric',
                'meta_description' => 'Learn about Plantaric\'s shipping methods, delivery charges, order processing, live plant packaging, and delivery procedures.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small mb-4">Last Updated: September 20, 2026</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Introduction</h3>
                    <p>At Plantaric, delivering living plants requires special care. Our shipping procedures are designed to support the safe transportation of plants and gardening products while keeping customers fully informed about their orders.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Shipping Availability</h3>
                    <p>Plantaric currently delivers live plants, pots, seeds, and gardening supplies to all major nationwide cities, regions, and regional delivery zones. Available shipping options and delivery rates are presented during checkout based on your delivery address.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Order Processing</h3>
                    <p>Orders are prepared for dispatch after payment verification is completed. Our standard processing time is <strong>1 to 3 business days</strong>. Processing times may be affected by extreme weather conditions (e.g., severe heatwaves or freezing cold) to protect live plant health in transit.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Shipping Methods & Charges</h3>
                    <ul>
                        <li><strong>Standard Ground Delivery:</strong> Delivered via standard courier service within 3–5 business days.</li>
                        <li><strong>Express Priority Delivery:</strong> Faster express shipping available for delicate foliage and perishable items.</li>
                        <li><strong>Free Shipping Threshold:</strong> Orders exceeding our qualifying free shipping threshold (e.g. Rs. 5,000) qualify for free standard ground delivery.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Live Plant Packaging</h3>
                    <p>Living plants require specialized packaging. Plantaric uses protective, insulated, moisture-retaining shipping containers to secure plants and pots during transit. Live plants may experience minor temporary stress during transport, which resolves after proper watering and indirect sunlight.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. Damaged Deliveries</h3>
                    <p>If your package arrives visibly damaged, please photograph the condition of the box and product and contact Plantaric support within 48 hours of arrival with your order number.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">7. Contact</h3>
                    <p>For shipping assistance, email <a href="mailto:shipping@plantaric.com">shipping@plantaric.com</a>.</p>
                ',
            ],
            [
                'title' => 'Return & Refund Policy',
                'slug' => 'return-refund-policy',
                'meta_title' => 'Return & Refund Policy | Plantaric',
                'meta_description' => 'Understand Plantaric\'s return and refund procedures for plants, gardening products, damaged deliveries, and order cancellations.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small mb-4">Last Updated: September 20, 2026</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Introduction</h3>
                    <p>At Plantaric, customer satisfaction and plant quality are paramount. This policy explains how we handle return requests, damaged deliveries, incorrect items, order cancellations, and refunds.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. 30-Day Healthy Plant Guarantee</h3>
                    <p>We guarantee that your plants arrive in healthy, viable condition. If a live plant arrives severely damaged, dead, or in poor health, please contact our support team within <strong>48 hours of delivery</strong> with clear photographs of the plant and packaging to receive a replacement or full refund.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Returns of Non-Living Products</h3>
                    <p>Non-perishable gardening products (ceramic pots, planters, tools, unopened soil bags, and fertilizers) may be returned within <strong>14 days of delivery</strong> provided they are unused and in original packaging.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Reporting Damaged or Incorrect Products</h3>
                    <p>To report an issue, email <a href="mailto:support@plantaric.com">support@plantaric.com</a> with your order number, product details, a short description of the issue, and clear photos of the items and box.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Refund Processing</h3>
                    <p>Once your return or damaged plant submission is verified, approved refunds are processed back to your original payment method within <strong>3 to 7 business days</strong>.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">6. Order Cancellations</h3>
                    <p>Orders may be cancelled prior to warehouse dispatch by contacting customer support. Once an order has shipped, standard return procedures apply.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">7. Contact</h3>
                    <p>For return assistance, contact <a href="mailto:support@plantaric.com">support@plantaric.com</a>.</p>
                ',
            ],
            [
                'title' => 'Advertising & Affiliate Disclosure',
                'slug' => 'advertising-disclosure',
                'meta_title' => 'Advertising Disclosure | Plantaric',
                'meta_description' => 'Learn how advertising and commercial partnerships help support Plantaric\'s botanical education, gardening articles, and plant care resources.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <p class="text-muted small mb-4">Last Updated: September 20, 2026</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">1. Introduction</h3>
                    <p>Plantaric is committed to transparency regarding commercial activities supporting our platform. We provide botanical care resources, plant identification tools, and gardening articles alongside our e-commerce marketplace.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">2. Display Advertising & Google AdSense</h3>
                    <p>Plantaric may display advertisements served by Google AdSense and other third-party advertising partners. These advertisements help support the continued operation of our free botanical encyclopedia. The display of an advertisement does not constitute an endorsement by Plantaric of the advertised product or service.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">3. Affiliate Relationships</h3>
                    <p>Some links to tools, soils, or gardening supplies may contain affiliate tracking codes. If you purchase a product through an affiliate link, Plantaric may receive a small commission at no extra cost to you.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">4. Product Recommendations</h3>
                    <p>Links within our Botanical Encyclopedia may direct readers to relevant plant care items or supplies available in our online shop. We present these commercial links transparently.</p>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">5. Contact</h3>
                    <p>For advertising or sponsorship inquiries, contact <a href="mailto:advertising@plantaric.com">advertising@plantaric.com</a>.</p>
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
