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
                'meta_title' => 'About Plantaric — Discover Plants. Grow Knowledge. Embrace Nature.',
                'meta_description' => 'Welcome to Plantaric, your online destination for plant discovery, gardening knowledge, botanical care, and plant marketplace.',
                'status' => 'published',
                'show_in_footer' => true,
                'is_system' => true,
                'content' => '
                    <h2>Welcome to Plantaric</h2>
                    <p class="lead">Growing Knowledge. Nurturing Nature. Inspiring Greener Living.</p>
                    <p>Welcome to Plantaric, your online destination for plant discovery, gardening knowledge, and botanical care.</p>
                    <p>At Plantaric, we believe that understanding plants is the first step toward growing healthier gardens and creating greener living spaces. Whether you are caring for your first indoor plant, exploring sustainable gardening practices, or looking for practical solutions to common plant problems, our goal is to make reliable plant knowledge accessible to everyone.</p>
                    <p>Plantaric brings together educational articles, plant care guides, botanical information, gardening news, and a plant marketplace in one convenient platform.</p>
                    <p>We aim to help plant enthusiasts, home gardeners, and agriculture learners make informed decisions about the plants they grow and the environments they create.</p>

                    <h3>Our Story</h3>
                    <p>Plantaric was created with a simple idea: plant care should be easier to understand and more accessible to everyone.</p>
                    <p>Finding reliable gardening information can sometimes be challenging. Different plants have different requirements, and advice that works for one growing environment may not work for another.</p>
                    <p>We developed Plantaric to bring useful botanical knowledge, practical gardening guidance, and plant discovery together in one place.</p>
                    <p>From understanding soil health and watering techniques to exploring indoor plants and sustainable agriculture, our platform focuses on helping readers develop the knowledge they need to grow with confidence.</p>
                    <p>As Plantaric continues to develop, our focus remains on providing helpful resources that support plant lovers at every stage of their gardening journey.</p>

                    <h3>What You\'ll Find on Plantaric</h3>
                    <ul>
                        <li><strong>Plant Encyclopedia:</strong> Discover information about different plant species, their characteristics, growing conditions, and care requirements. Our plant encyclopedia helps readers understand the basics of plant selection and maintenance, including sunlight, watering, soil preferences, and common growing challenges.</li>
                        <li><strong>Gardening Articles & Guides:</strong> Explore educational articles covering a wide range of plant and gardening topics. Our content includes soil health, plant nutrition, indoor gardening, sustainable growing practices, pest management, and seasonal plant care. We focus on presenting information in clear, practical language that readers can understand and apply in their own gardens.</li>
                        <li><strong>Plant Care & Growing Knowledge:</strong> Every plant has unique requirements, and understanding those needs can make a meaningful difference in its growth. Plantaric provides information to help readers recognize common plant problems, understand environmental factors, and explore appropriate care practices. From yellowing leaves to soil conditions and watering mistakes, our goal is to make plant care knowledge easier to access.</li>
                        <li><strong>Plant Marketplace:</strong> Plantaric also provides an online marketplace where visitors can explore plants and gardening-related products. Our marketplace is designed to connect plant discovery with practical growing needs, allowing visitors to explore botanical products alongside educational resources.</li>
                        <li><strong>Botanical News & Insights:</strong> Stay informed about developments in gardening, agriculture, plant science, and environmental sustainability. Through our news and informational content, we aim to share useful developments that help readers understand the changing world of plants and agriculture.</li>
                    </ul>

                    <h3>Our Mission</h3>
                    <p>Our mission is to make plant knowledge accessible, practical, and valuable for everyone.</p>
                    <p>We strive to support a growing community of plant enthusiasts by providing educational resources, encouraging responsible gardening practices, and making botanical information easier to understand.</p>
                    <p>Whether someone is growing a small indoor collection or managing a larger outdoor garden, we want Plantaric to be a helpful resource throughout their journey.</p>

                    <h3>Our Commitment to Quality Information</h3>
                    <p>We understand that readers rely on accurate information when making decisions about plant health, gardening practices, and growing conditions.</p>
                    <p>That is why we aim to develop content that is informative, clearly written, and grounded in relevant botanical and agricultural knowledge.</p>
                    <p>Our editorial process may involve research, publicly available educational resources, digital tools, and AI-assisted content development. We aim to review and improve published material for clarity, relevance, and factual accuracy.</p>
                    <p>As gardening practices and scientific understanding continue to evolve, we may update our content to reflect new information and improve the experience for our readers.</p>
                    <p>For additional information about how our content is developed, please visit our <a href="/editorial-policy">Editorial Policy</a>.</p>

                    <h3>Growing a Greener Future Together</h3>
                    <p>At Plantaric, we believe that even small steps toward understanding and caring for plants can contribute to healthier homes, greener communities, and a greater appreciation for nature.</p>
                    <p>Our vision is to build a platform where knowledge, discovery, and gardening come together to inspire people to grow.</p>
                    <p>Whether you are beginning your first gardening project or expanding your botanical knowledge, we welcome you to explore, learn, and grow with Plantaric.</p>

                    <p><strong>Plantaric — Discover Plants. Grow Knowledge. Embrace Nature.</strong></p>
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

                    <h3 id="cookies" class="h5 font-weight-bold mt-4 mb-2">7. Cookies and Tracking Technologies</h3>
                    <p>Plantaric uses cookies and similar session technologies to provide core website functionality, maintain secure login sessions, preserve cart contents, store user preferences, measure website performance, and support online advertising.</p>
                    <ul>
                        <li><strong>Essential Cookies:</strong> Support core operations such as authentication, cart storage, checkout processing, and CSRF protection. Disabling essential cookies may impair site functionality.</li>
                        <li><strong>Preference & Analytics Cookies:</strong> Store user preferences (e.g. shipping location or filter choices) and gather aggregated usage metrics to help us continuously improve Plantaric.</li>
                        <li><strong>Advertising & Google AdSense Cookies:</strong> Third-party partners, including Google AdSense, use cookies to serve relevant ads based on prior website visits. Visitors can manage ad preferences via <a href="https://myadcenter.google.com/" target="_blank" rel="noopener">Google\'s My Ad Center</a>.</li>
                    </ul>
                    <p>You can manage or block optional cookies through your web browser settings without losing access to our free botanical encyclopedia resources.</p>

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
                    <p>Plantaric provides botanical information for educational and informational purposes. Our content includes plant identification, scientific classification, watering recommendations, sunlight requirements, soil information, seasonal maintenance, and plant health troubleshooting. Individual plant requirements may vary depending on climate and micro-environment. Please review Section 12 below for our complete Botanical & Plant Care Disclaimer.</p>

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

                    <h3 id="disclaimer" class="h5 font-weight-bold mt-4 mb-2">11. Botanical & Plant Care Disclaimer</h3>
                    <p>The botanical care guides, encyclopedia entries, and health troubleshooting tips published on Plantaric are provided strictly for general educational purposes:</p>
                    <ul>
                        <li><strong>General Guidelines:</strong> Care parameters (watering frequency, light intensity, soil pH, fertilization) are general reference points. Actual plant growth depends on your specific climate and micro-environment.</li>
                        <li><strong>Diagnostic Lookup:</strong> Symptom lookup tools and care recommendations serve as helpful educational aids, not absolute laboratory diagnostic guarantees.</li>
                        <li><strong>Plant Toxicity & Safety:</strong> Toxicity ratings for pets and humans are compiled from standard botanical literature. In case of accidental ingestion or severe exposure, consult medical or veterinary professionals immediately.</li>
                    </ul>

                    <h3 class="h5 font-weight-bold mt-4 mb-2">12. Contact</h3>
                    <p>For questions regarding these Terms & Conditions, contact:</p>
                    <p class="mb-0"><strong>Plantaric Legal Team</strong><br>Email: <a href="mailto:support@plantaric.com">support@plantaric.com</a><br>Website: <a href="https://plantaric.com">plantaric.com</a></p>
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
        ];

        Page::whereIn('slug', ['cookie-policy', 'disclaimer', 'advertising-disclosure'])->delete();

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
