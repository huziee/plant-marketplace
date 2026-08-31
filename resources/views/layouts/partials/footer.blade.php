<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a class="brand" href="{{ url('/') }}" style="color:white">
                    <span class="brand-mark"><i class="fa-solid fa-seedling"></i></span>Plantaric
                </a>
                <p>An all-in-one plant discovery, care, and commerce platform connecting plant lovers with knowledge, products, and trusted advice.</p>
                <div class="socials">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" aria-label="Pinterest"><i class="fa-brands fa-pinterest-p"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Shop</h4>
                <a href="{{ route('shop.index') }}">Indoor Plants</a>
                <a href="{{ route('shop.index') }}">Outdoor Plants</a>
                <a href="{{ route('shop.index') }}">Seeds & Bulbs</a>
                <a href="{{ route('shop.index') }}">Pots & Planters</a>
                <a href="{{ route('shop.index') }}">Plant Care</a>
            </div>
            <div class="footer-col">
                <h4>Discover</h4>
                <a href="{{ route('plants.index') }}">Plant Encyclopedia</a>
                <a href="{{ route('problems.index') }}">Plant Doctor</a>
                <a href="{{ route('guides.index') }}">Care Guides</a>
                <a href="{{ route('articles.index') }}">Articles</a>
                <a href="{{ route('news.index') }}">Plant News</a>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <a href="{{ route('frontend.about') }}">About Us</a>
                <a href="{{ route('frontend.contact') }}">Contact Us</a>
                <a href="{{ route('frontend.editorial-policy') }}">Editorial Policy</a>
                <a href="{{ route('frontend.advertising-disclosure') }}">Advertising Disclosure</a>
            </div>
            <div class="footer-col">
                <h4>Policies</h4>
                <a href="{{ route('frontend.privacy') }}">Privacy Policy</a>
                <a href="{{ route('frontend.terms') }}">Terms & Conditions</a>
                <a href="{{ route('frontend.cookie-policy') }}">Cookie Policy</a>
                <a href="{{ route('frontend.disclaimer') }}">Plant Care Disclaimer</a>
                <a href="{{ route('frontend.shipping-policy') }}">Shipping Policy</a>
                <a href="{{ route('frontend.return-refund-policy') }}">Return & Refund Policy</a>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} Plantaric. All rights reserved.</span>
            <span>Designed for E-Commerce · Botanical Care · Search Indexing · AdSense</span>
        </div>
    </div>
</footer>
