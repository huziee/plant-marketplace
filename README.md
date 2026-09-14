<p align="center">
  <img src="public/images/plantaric-logo.png" width="480" alt="Plantaric Logo">
</p>

<h1 align="center">Plantaric — E-Commerce Marketplace & Botanical Encyclopedia Platform</h1>

<p align="center">
  <b>A comprehensive, production-ready Laravel 12 full-stack application combining a modern plant marketplace, botanical encyclopedia, diagnostic plant doctor, CMS legal page manager, multi-author editorial publishing platform, and RBAC admin portal.</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4+">
  <img src="https://img.shields.io/badge/TailwindCSS-v4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5.3">
  <img src="https://img.shields.io/badge/Vite-7.0-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

---

## 🌿 System Overview

**Plantaric** is an enterprise-grade, feature-packed web platform built for botanical retail stores, online plant nurseries, horticultural brands, and plant care communities. The system harmoniously integrates six major operational engines:

1. **E-Commerce Marketplace**: Full product catalog, multi-attribute variants, custom studio table photography, dynamic price/category filtering, slide-over cart drawer, discount coupon engine, real-time shipping calculation, multi-step checkout, wishlist persistence, customer reviews with verified badges, and order tracking.
2. **Botanical Encyclopedia**: Detailed species index complete with scientific taxonomy, plant families, native origins, toxicity alerts (pet & child safety), watering/light/soil matrices, and seasonal care guides (Spring, Summer, Autumn, Winter).
3. **Plant Doctor Diagnostic Portal**: Interactive symptom-to-treatment lookup system mapping leaf discoloration, pests, fungal infections, and environmental stress to multi-tier remedies (Organic, Chemical, Cultural adjustments).
4. **Editorial Publishing System**: Rich multi-author blogging suite for botanical articles, step-by-step growing guides, and plant news with JSON-LD microdata schema markup (`Article`, `NewsArticle`, `Product`, `Organization`).
5. **Page CMS & Trust Documentation Engine**: Dynamic page builder for legal policies and corporate documentation featuring a system-page protection lock, honeypot anti-spam protection on contact inquiries, and admin message management.
6. **Admin Operations Portal (RBAC)**: Comprehensive administration center with role-based access control (`admin`, `editor`, `author`), order fulfillment pipeline, inventory movement audit log, review moderation, media library, and key-value system settings.

---

## 🏗️ System Architecture

```mermaid
graph TD
    User([Public Visitor / Customer]) --> Frontend[Frontend Store & Content Engine]
    Admin([Admin / Editor / Author]) --> AdminPanel[Admin Operations Portal]

    subgraph Frontend Subsystems
        Frontend --> Shop[Shop Catalog & Product Pages]
        Frontend --> CartCheckout[Cart Drawer & Multi-Step Checkout]
        Frontend --> PlantDB[Botanical Encyclopedia]
        Frontend --> PlantDoc[Plant Doctor Diagnostics]
        Frontend --> Content[Articles, Guides & Newsroom]
        Frontend --> Account[Customer Dashboard & Orders]
        Frontend --> Modals[Quick View & Search Modals]
    end

    subgraph Admin Operations
        AdminPanel --> Inventory[Inventory Movement & Stock Ledger]
        AdminPanel --> OrderMgmt[Order Status & Fulfillment Pipeline]
        AdminPanel --> CouponEngine[Coupon & Promotional Discount Rules]
        AdminPanel --> ContentMgmt[Post & Encyclopedia Editors + Cloning]
        AdminPanel --> ReviewMod[Review Moderation Queue]
        AdminPanel --> CMSInbox[Page CMS & Contact Inbox]
        AdminPanel --> SystemSettings[Dynamic Key-Value Settings Engine]
    end

    subgraph Database Layer (43 Eloquent Models)
        Shop & CartCheckout & PlantDB & PlantDoc & Content & Account & Modals --> DB[(MySQL / SQLite Database)]
        Inventory & OrderMgmt & CouponEngine & ContentMgmt & ReviewMod & CMSInbox & SystemSettings --> DB
    end
```

---

## ✨ Exhaustive Feature Matrix

### 🛒 1. E-Commerce Marketplace & Checkout Engine

| Feature | Technical Description & Implementation |
| :--- | :--- |
| **Product Catalog (`/shop`)** | Searchable product grid with category multi-select, interactive price range sliders, in-stock availability toggles, and sorting options (Price Low-to-High, High-to-Low, Latest, Top Rated). |
| **Multi-Attribute Product Variants** | Support for complex SKU variations (e.g., Pot Color, Size, Package Weight) backed by `ProductVariant`, `ProductAttribute`, and `ProductAttributeValue` models. |
| **Studio Photography & Visual Assets** | 4K ultra-realistic studio photography for indoor plants on wooden tables (`public/images/products/*_table.jpg`) paired with HD category covers (`public/images/categories/*.jpg`). |
| **Slide-Over Cart Drawer & Full Cart** | Slide-over cart drawer (`drawer.blade.php`) and full `/cart` page with AJAX quantity updates, subtotal auto-calculation, line-item removal, and persistent session/database cart container (`Cart`, `CartItem`). |
| **Discount Coupon Engine** | Percentage-based or fixed-amount promo codes supporting minimum order thresholds, maximum discount caps, per-user usage caps, expiration dates, and real-time validation (`coupons`, `coupon_usages`). |
| **Dynamic Shipping Calculation** | Configurable shipping providers (Flat Rate, Express Delivery, Free Shipping Thresholds, Nursery Pickup) dynamically updated during checkout (`shipping_methods`). |
| **Multi-Step Checkout (`/checkout`)** | Saved customer address auto-population, dynamic fee breakdown, order generation with unique tracking codes (`PLN-YYYYMMDD-XXXX`), and automatic stock decrementing. |
| **Product Reviews & Verified Ratings** | 1–5 star rating system, text feedback, customer verified buyer badges, and an admin approval workflow (`product_reviews`). |
| **AJAX Customer Wishlist** | Instant wishlist bookmarking with session/user persistence and dedicated customer account wishlist view (`wishlists`). |
| **Quick View Modal** | Instant product quick-view modal (`quick_view_modal.blade.php`) allowing customers to preview variants, stock, and add items to cart without leaving the page. |

---

### 🪴 2. Botanical Encyclopedia (`/plants`)

| Feature | Technical Description & Implementation |
| :--- | :--- |
| **Species Directory** | Comprehensive plant catalog with scientific taxonomy (Family, Genus, Species), geographic origin, growth rate, mature height, and pet/child toxicity warnings (`plants`, `plant_categories`). |
| **Granular Care Matrix** | Environment care specifications (`plant_cares`): ☀️ Light intensity & orientation, 💧 Watering frequency & humidity target %, 🧪 Soil mixture & pH range, 🌡️ Min/max temperature tolerance, 🌿 Fertilizer type & feeding cycle, ✂️ Pruning & repotting frequency. |
| **Common & Regional Names Index** | Multi-alias directory (`plant_common_names`) allowing lookup by regional names (e.g., *Monstera deliciosa* vs. *Swiss Cheese Plant* or *Split-Leaf Philodendron*). |
| **Seasonal Care Routines** | Specialized seasonal maintenance guidelines for Spring, Summer, Autumn, and Winter growth cycles (`plant_seasons`). |

---

### 🩺 3. Plant Doctor Diagnostic Portal (`/plant-problems`)

| Feature | Technical Description & Implementation |
| :--- | :--- |
| **Visual Symptom Diagnostic Index** | Diagnostic engine indexing leaf discoloration, yellowing, pest infestations, root rot, fungal spots, and wilting symptoms (`plant_problems`, `plant_problem_symptoms`). |
| **Pathogen & Root Cause Analysis** | In-depth cause classification (`plant_problem_causes`) identifying biological (fungal, insect, bacterial, viral) or environmental (overwatering, light burn) origins. |
| **Multi-Tier Treatment Protocol** | Actionable recovery procedures (`plant_problem_treatments`) divided into Organic Remedies, Chemical Interventions, and Cultural/Environmental Adjustments. |
| **Prevention & Vulnerable Hosts** | Long-term preventative care guidelines (`plant_problem_preventions`) linked directly to vulnerable host plant species. |

---

### 📰 4. Multi-Author Editorial Engine (`/articles`, `/guides`, `/news`)

| Feature | Technical Description & Implementation |
| :--- | :--- |
| **Triple-Format Publishing Suite** | Manage Botanical Articles (`/articles`), Step-by-Step Growing Tutorials (`/guides`), and Industry News (`/news`) with rich text, featured cover media, estimated reading time, and publication states (`posts`). |
| **Taxonomy & Cross-Tagging System** | Flexible content categorization (`content_categories`) and tagging engine (`tags`) shared across content and product catalogs. |
| **Author Profiles & Archives** | Dedicated author profile pages (`/authors/{user}`) showcasing author bios, avatars, social profiles, and published article indexes (`author_profiles`). |
| **Citations & Research Sources** | Academic and authoritative reference citations (`post_sources`) attached to research articles. |
| **JSON-LD Schema Markup** | Built-in structured data generation (`Article`, `NewsArticle`, `Product`, `Organization`, `BreadcrumbList`) for Google Search Rich Snippets. |

---

### 📄 5. CMS Page Engine & Trust Documentation

| Feature | Technical Description & Implementation |
| :--- | :--- |
| **Dynamic Page CMS (`/admin/pages`)** | Full CRUD page manager to compose, format, edit, and publish static site pages with custom SEO title and description meta tags (`pages`). |
| **System Page Lock Protection** | Core legal policies (`privacy-policy`, `terms-and-conditions`, `disclaimer`, `cookie-policy`, etc.) feature deletion and slug modification locks (`is_system`) to protect application routing integrity. |
| **10 Pre-Seeded Trust Pages** | Ready-to-use templates for `/about-us`, `/contact-us`, `/privacy-policy`, `/terms-and-conditions`, `/cookie-policy`, `/disclaimer`, `/editorial-policy`, `/shipping-policy`, `/return-refund-policy`, and `/advertising-disclosure`. |
| **Honeypot Anti-Spam Shield** | Customer contact forms incorporate a invisible honeypot field (`website`) that automatically detects and rejects automated bot spam without database pollution. |
| **Contact Inquiry Inbox** | Admin communication center (`/admin/contact-messages`) to inspect customer submissions, manage status lifecycle (`unread`, `replied`, `archived`), and store administrative response notes (`contact_messages`). |
| **Cookie Consent Banner** | Non-intrusive cookie notice bar (`cookie_consent.blade.php`) compliant with GDPR & ePrivacy directives. |

---

### 👤 6. Customer Account Portal (`/account`)

| Feature | Technical Description & Implementation |
| :--- | :--- |
| **Account Overview Dashboard** | Customer dashboard displaying recent orders, default shipping address summary, account metrics, and wishlist bookmarks (`/account/dashboard`). |
| **Order History & Cancellation** | Comprehensive order log (`/account/orders`) with line item breakdowns, pricing summaries, tracking details, and one-click order cancellation for pending orders. |
| **Address Book Manager** | Full CRUD address manager (`customer_addresses`) supporting primary billing and shipping address assignment flags. |
| **Customer Wishlist Hub** | Unified overview of bookmarked products with direct "Add to Cart" capability (`/account/wishlist`). |

---

### ⚙️ 7. Admin Operations Portal (`/admin`)

| Feature | Technical Description & Implementation |
| :--- | :--- |
| **Role-Based Access Control (RBAC)** | Protected by `auth` and `role:admin,editor,author` authorization middleware guarding operational routes. |
| **Operations Dashboard** | Real-time metric cards showing Total Revenue, Total Orders, Active Product Count, Registered Customers, and Low-Stock Warning alerts (`/admin`). |
| **Inventory Movement Ledger** | Historical audit trail (`inventory_movements`) tracking all stock adjustments: Stock In, Sales Deductions, Customer Returns, and Manual Adjustments (`/admin/inventory`). |
| **Order Fulfillment Pipeline** | Process orders through state changes (`Pending` ➔ `Processing` ➔ `Shipped` ➔ `Delivered` ➔ `Cancelled`) with automated status history log entries (`order_status_histories`). |
| **Record Duplication & Cloning** | One-click duplication for Plants (`POST /admin/plants/{id}/duplicate`) and Content Posts (`POST /admin/posts/{id}/duplicate`). |
| **Live Article Preview** | Secret author preview engine (`GET /admin/posts/{id}/preview`) allowing authors to review draft posts before public launch. |
| **Review Moderation Queue** | Approve, flag, or purge customer product reviews before public storefront display (`/admin/reviews`). |
| **Central Media Library** | Unified media hub (`/admin/media`) supporting multi-file image uploads, thumbnail generation, MIME type detection, alt text management, and file size tracking. |
| **Newsletter Leads Manager** | Subscriber management directory (`newsletter_subscribers`) capturing email leads from footer and homepage subscription modules. |
| **Dynamic Key-Value Settings Engine** | Centralized configuration center (`/admin/settings`) to dynamically control Site Name, Logo, Contact Info, Social Links, Currency Symbol, and Default SEO metadata stored in the `settings` table. |

---

### 🌐 8. SEO, Performance & System Utilities

| Feature | Technical Description & Implementation |
| :--- | :--- |
| **Automated XML Sitemaps** | Dynamic sitemap generator (`/sitemap.xml`) serving specialized sitemaps for `/sitemaps/products.xml`, `/sitemaps/plants.xml`, and `/sitemaps/posts.xml`. |
| **URL Redirection Engine** | Database-managed 301/302 redirection table (`url_redirects`) ensuring zero broken links during permalink updates. |
| **Complete Favicon & PWA Suite** | Multi-resolution ICO (16x16, 32x32, 48x48, 64x64), SVG vector icon, Apple Touch Icon (180x180), Android Chrome icons (192x192, 512x512), and `site.webmanifest`. |
| **Branded Error Pages** | Custom responsive error views for `404 Not Found`, `403 Forbidden`, `419 Page Expired`, and `500 Internal Server Error` (`resources/views/errors/`). |
| **Global Search Overlay** | Universal search modal (`search_modal.blade.php`) querying products, encyclopedia entries, growing guides, and articles simultaneously (`SearchController`). |

---

## 🗄️ Database Schema & Model Directory (43 Eloquent Models)

The system database consists of **43 specialized Eloquent data models**:

| Group | Model Class | Database Table | Primary Purpose & Key Relationships |
| :--- | :--- | :--- | :--- |
| **Core & Users** | [`User`](file:///c:/laragon/www/plant-marketplace/app/Models/User.php) | `users` | User authentication, RBAC roles (`admin`, `editor`, `author`, `customer`), password hashes, and avatars. |
| | [`AuthorProfile`](file:///c:/laragon/www/plant-marketplace/app/Models/AuthorProfile.php) | `author_profiles` | Bio, credentials, title, and social links for content authors (`belongsTo(User)`). |
| | [`CustomerAddress`](file:///c:/laragon/www/plant-marketplace/app/Models/CustomerAddress.php) | `customer_addresses` | Saved customer billing and shipping addresses (`belongsTo(User)`). |
| **Marketplace** | [`Product`](file:///c:/laragon/www/plant-marketplace/app/Models/Product.php) | `products` | Product catalog items, pricing, SKUs, stock levels, featured flags, and SEO attributes. |
| | [`ProductCategory`](file:///c:/laragon/www/plant-marketplace/app/Models/ProductCategory.php) | `product_categories` | Hierarchical product categories (Indoor Plants, Outdoor Plants, Seeds, Pots, Tools). |
| | [`ProductCollection`](file:///c:/laragon/www/plant-marketplace/app/Models/ProductCollection.php) | `product_collections` | Dynamic product groupings (Best Sellers, Low Light Favorites, New Arrivals). |
| | [`ProductVariant`](file:///c:/laragon/www/plant-marketplace/app/Models/ProductVariant.php) | `product_variants` | Specific product SKU variations (size, color, pot style) with override prices and stock. |
| | [`ProductAttribute`](file:///c:/laragon/www/plant-marketplace/app/Models/ProductAttribute.php) | `product_attributes` | Variant attribute keys (e.g., Color, Pot Diameter, Weight). |
| | [`ProductAttributeValue`](file:///c:/laragon/www/plant-marketplace/app/Models/ProductAttributeValue.php) | `product_attribute_values` | Concrete attribute options (e.g., Terracotta, Ceramic White, Small, Large). |
| | [`ProductImage`](file:///c:/laragon/www/plant-marketplace/app/Models/ProductImage.php) | `product_images` | Product gallery assets with primary image flags and display ordering. |
| | [`ProductReview`](file:///c:/laragon/www/plant-marketplace/app/Models/ProductReview.php) | `product_reviews` | Customer ratings (1-5), review text, verified buyer status, and admin approval flags. |
| **Cart & Orders** | [`Cart`](file:///c:/laragon/www/plant-marketplace/app/Models/Cart.php) | `carts` | Cart containers linked to session IDs or registered customer user IDs. |
| | [`CartItem`](file:///c:/laragon/www/plant-marketplace/app/Models/CartItem.php) | `cart_items` | Individual cart line items with selected variant and quantity. |
| | [`Order`](file:///c:/laragon/www/plant-marketplace/app/Models/Order.php) | `orders` | Master order records containing tracking numbers, payment state, shipping costs, and grand totals. |
| | [`OrderItem`](file:///c:/laragon/www/plant-marketplace/app/Models/OrderItem.php) | `order_items` | Purchased order line item snapshots (product name, unit price, quantity, variant details). |
| | [`OrderStatusHistory`](file:///c:/laragon/www/plant-marketplace/app/Models/OrderStatusHistory.php) | `order_status_histories` | Audit log tracking order state transitions with timestamps and admin comments. |
| | [`Payment`](file:///c:/laragon/www/plant-marketplace/app/Models/Payment.php) | `payments` | Transaction receipts, payment method types, reference IDs, and payment status. |
| | [`ShippingMethod`](file:///c:/laragon/www/plant-marketplace/app/Models/ShippingMethod.php) | `shipping_methods` | Shipping rules, flat rates, free shipping order minimums, and delivery timelines. |
| | [`Coupon`](file:///c:/laragon/www/plant-marketplace/app/Models/Coupon.php) | `coupons` | Promotional promo codes, percentage/fixed discounts, usage limits, and validity dates. |
| | [`CouponUsage`](file:///c:/laragon/www/plant-marketplace/app/Models/CouponUsage.php) | `coupon_usages` | Ledger logging coupon redemptions per user and per order. |
| | [`InventoryMovement`](file:///c:/laragon/www/plant-marketplace/app/Models/InventoryMovement.php) | `inventory_movements` | Stock ledger tracking stock ins, order sales deductions, returns, and manual adjustments. |
| | [`Wishlist`](file:///c:/laragon/www/plant-marketplace/app/Models/Wishlist.php) | `wishlists` | User product bookmarks (`belongsTo(User)`, `belongsTo(Product)`). |
| **Plant Encyclopedia**| [`Plant`](file:///c:/laragon/www/plant-marketplace/app/Models/Plant.php) | `plants` | Botanical species profiles, scientific taxonomy, pet safety flags, and growth traits. |
| | [`PlantCategory`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantCategory.php) | `plant_categories` | Botanical taxonomy classifications (Succulents, Tropicals, Ferns, Palms). |
| | [`PlantCare`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantCare.php) | `plant_cares` | Precise environmental care parameters (light, water, soil pH, fertilizer, temp range). |
| | [`PlantCommonName`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantCommonName.php) | `plant_common_names` | Common and regional aliases for species lookups. |
| | [`PlantImage`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantImage.php) | `plant_images` | High-resolution botanical photography assets. |
| | [`PlantSeason`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantSeason.php) | `plant_seasons` | Seasonal growth and dormant care routines for Spring, Summer, Autumn, and Winter. |
| **Plant Doctor** | [`PlantProblem`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantProblem.php) | `plant_problems` | Diagnostic entries for diseases, pests, fungal infections, and physiological stress. |
| | [`PlantProblemSymptom`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantProblemSymptom.php) | `plant_problem_symptoms` | Leaf indicators, stem damage, and root condition symptoms. |
| | [`PlantProblemCause`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantProblemCause.php) | `plant_problem_causes` | Biological pathogens (insects, fungi, bacteria) and environmental causes. |
| | [`PlantProblemTreatment`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantProblemTreatment.php) | `plant_problem_treatments` | Organic remedies, chemical treatments, and cultural adjustments. |
| | [`PlantProblemPrevention`](file:///c:/laragon/www/plant-marketplace/app/Models/PlantProblemPrevention.php) | `plant_problem_preventions` | Long-term preventative maintenance routines. |
| **Content Engine** | [`Post`](file:///c:/laragon/www/plant-marketplace/app/Models/Post.php) | `posts` | Botanical articles, step-by-step guides, and industry news posts (`belongsTo(User)`). |
| | [`ContentCategory`](file:///c:/laragon/www/plant-marketplace/app/Models/ContentCategory.php) | `content_categories` | Editorial content categories. |
| | [`Tag`](file:///c:/laragon/www/plant-marketplace/app/Models/Tag.php) | `tags` | Tags shared across posts and marketplace products. |
| | [`PostSource`](file:///c:/laragon/www/plant-marketplace/app/Models/PostSource.php) | `post_sources` | Research citations and reference sources for editorial articles. |
| **Page CMS & Trust**| [`Page`](file:///c:/laragon/www/plant-marketplace/app/Models/Page.php) | `pages` | Static legal policies and corporate pages with `is_system` deletion locks. |
| | [`ContactMessage`](file:///c:/laragon/www/plant-marketplace/app/Models/ContactMessage.php) | `contact_messages` | Customer inquiry submissions with status tracking and reply notes. |
| **System Utilities** | [`Media`](file:///c:/laragon/www/plant-marketplace/app/Models/Media.php) | `media` | Central media library records tracking uploaded file paths, sizes, and MIME types. |
| | [`Setting`](file:///c:/laragon/www/plant-marketplace/app/Models/Setting.php) | `settings` | Dynamic key-value site configuration store. |
| | [`NewsletterSubscriber`](file:///c:/laragon/www/plant-marketplace/app/Models/NewsletterSubscriber.php)| `newsletter_subscribers`| Captured email marketing newsletter subscribers. |
| | [`UrlRedirect`](file:///c:/laragon/www/plant-marketplace/app/Models/UrlRedirect.php) | `url_redirects` | Database-driven 301/302 URL redirection table. |

---

## 🛣️ Complete System Route Map

### 🌐 1. Public Frontend & Content Routes (`routes/web.php`)

| Method | Path | Controller & Action | Route Name | Description |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/` | `Frontend\HomeController@index` | `frontend.home` | Homepage featuring hero banner, global search, top categories, desk plant showcase, plant doctor features, guides, and news. |
| `GET` | `/shop` | `Frontend\ShopController@index` | `shop.index` | Storefront catalog with category multi-select, price sliders, stock filters, and sorting controls. |
| `GET` | `/shop/category/{slug}` | `Frontend\ShopController@category` | `frontend.shop.category` | Category product showcase page. |
| `GET` | `/shop/products/{slug}` | `Frontend\ShopController@show` | `frontend.shop.product` | Product detail page with table photos, variant selectors, stock badge, quick view support, and reviews. |
| `GET` | `/cart` | `Frontend\CartController@index` | `frontend.cart.index` | Full shopping cart page. |
| `POST` | `/cart/add` | `Frontend\CartController@add` | `frontend.cart.add` | Add product or variant to cart. |
| `PUT` | `/cart/items/{id}` | `Frontend\CartController@update` | `frontend.cart.update` | Update cart item quantity. |
| `DELETE` | `/cart/items/{id}` | `Frontend\CartController@remove` | `frontend.cart.remove` | Remove item from cart. |
| `POST` | `/cart/coupon` | `Frontend\CartController@applyCoupon` | `frontend.cart.coupon` | Apply promo coupon code to cart. |
| `DELETE` | `/cart/coupon` | `Frontend\CartController@removeCoupon` | `frontend.cart.coupon.remove` | Remove coupon from cart. |
| `GET` | `/plants` | `Frontend\PlantController@index` | `plants.index` | Botanical Encyclopedia species directory. |
| `GET` | `/plants/{plant:slug}` | `Frontend\PlantController@show` | `plants.show` | Detailed plant profile with light, water, soil care matrix, pet toxicity warnings, and seasonal routines. |
| `GET` | `/plant-problems` | `Frontend\PlantProblemController@index` | `problems.index` | Plant Doctor diagnostic index. |
| `GET` | `/plant-problems/{plantProblem:slug}` | `Frontend\PlantProblemController@show` | `problems.show` | Symptom lookup, pathogen analysis, multi-tier treatments, and prevention tips. |
| `GET` | `/articles` | `Frontend\ArticleController@index` | `articles.index` | Botanical articles archive. |
| `GET` | `/articles/category/{slug}` | `Frontend\ContentCategoryController@show` | `content-categories.show` | Articles filtered by content category. |
| `GET` | `/articles/{slug}` | `Frontend\ArticleController@show` | `articles.show` | Article view with author bio, citations, and JSON-LD schema. |
| `GET` | `/guides` | `Frontend\GuideController@index` | `guides.index` | Step-by-step growing tutorials index. |
| `GET` | `/guides/{slug}` | `Frontend\GuideController@show` | `guides.show` | Detailed growing guide tutorial. |
| `GET` | `/news` | `Frontend\NewsController@index` | `news.index` | Plant and botanical newsroom. |
| `GET` | `/news/{slug}` | `Frontend\NewsController@show` | `news.show` | News article detail view. |
| `GET` | `/authors/{user}` | `Frontend\AuthorController@show` | `authors.show` | Author bio archive displaying written posts. |
| `GET` | `/about-us` | `Frontend\PageController@about` | `frontend.about` | About Plantaric company overview. |
| `GET` | `/contact-us` | `Frontend\PageController@contact` | `frontend.contact` | Contact page featuring honeypot spam protection. |
| `POST` | `/contact-us` | `Frontend\PageController@submitContact` | `frontend.contact.submit` | Submit contact inquiry (throttled `5,1` per min). |
| `GET` | `/privacy-policy` | `Frontend\PageController@show` | `frontend.privacy` | Privacy Policy documentation. |
| `GET` | `/terms-and-conditions` | `Frontend\PageController@show` | `frontend.terms` | Terms & Conditions agreement. |
| `GET` | `/cookie-policy` | `Frontend\PageController@show` | `frontend.cookie-policy` | Cookie Consent & Policy document. |
| `GET` | `/disclaimer` | `Frontend\PageController@show` | `frontend.disclaimer` | Plant Care & Medical Disclaimer. |
| `GET` | `/editorial-policy` | `Frontend\PageController@show` | `frontend.editorial-policy` | Botanical Publishing & Review Policy. |
| `GET` | `/shipping-policy` | `Frontend\PageController@show` | `frontend.shipping-policy` | Shipping & Nursery Delivery Policy. |
| `GET` | `/return-refund-policy` | `Frontend\PageController@show` | `frontend.return-refund-policy` | Returns & Guarantee Policy. |
| `GET` | `/advertising-disclosure` | `Frontend\PageController@show` | `frontend.advertising-disclosure` | Affiliate & Advertising Disclosure. |
| `GET` | `/page/{slug}` | `Frontend\PageController@show` | `frontend.page.show` | Dynamic CMS page loader. |
| `GET` | `/search` | `Frontend\SearchController@index` | `search.index` | Global search engine querying products, plants, guides, and articles. |
| `POST` | `/newsletter/subscribe` | `Frontend\NewsletterController@subscribe` | `newsletter.subscribe` | Newsletter opt-in submission. |
| `GET` | `/sitemap.xml` | `Frontend\SitemapController@index` | `sitemap` | Master XML sitemap index. |
| `GET` | `/sitemaps/{type}.xml` | `Frontend\SitemapController@show` | `sitemap.show` | Specialized sitemap (`products`, `plants`, `posts`). |

---

### 🔐 2. Authentication & Customer Portal Routes (`routes/web.php`)

| Method | Path | Controller & Action | Route Name | Middleware |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/login` | `Auth\LoginController@showLoginForm` | `login` | `guest` |
| `POST` | `/login` | `Auth\LoginController@login` | `login` | `guest` |
| `POST` | `/logout` | `Auth\LoginController@logout` | `logout` | `auth` |
| `GET` | `/register` | `Auth\RegisterController@showRegistrationForm` | `register` | `guest` |
| `POST` | `/register` | `Auth\RegisterController@register` | `register` | `guest` |
| `GET` | `/forgot-password` | `Auth\ForgotPasswordController@showLinkRequestForm` | `password.request` | `guest` |
| `POST` | `/forgot-password` | `Auth\ForgotPasswordController@sendResetLinkEmail` | `password.email` | `guest` |
| `GET` | `/reset-password/{token}` | `Auth\ResetPasswordController@showResetForm` | `password.reset` | `guest` |
| `POST` | `/reset-password` | `Auth\ResetPasswordController@reset` | `password.update` | `guest` |
| `GET` | `/email/verify` | `Auth\VerificationController@show` | `verification.notice` | `auth` |
| `GET` | `/email/verify/{id}/{hash}` | `Auth\VerificationController@verify` | `verification.verify` | `auth`, `signed` |
| `POST` | `/email/verification-notification` | `Auth\VerificationController@resend` | `verification.send` | `auth`, `throttle:6,1` |
| `POST` | `/wishlist/toggle/{product}` | `Frontend\WishlistController@toggle` | `frontend.wishlist.toggle` | `auth` |
| `GET` | `/checkout` | `Frontend\CheckoutController@index` | `frontend.checkout.index` | `auth` |
| `POST` | `/checkout` | `Frontend\CheckoutController@process` | `frontend.checkout.process` | `auth` |
| `GET` | `/checkout/success/{order_number}` | `Frontend\CheckoutController@success` | `frontend.checkout.success` | `auth` |
| `GET` | `/account/dashboard` | `Frontend\CustomerAccountController@dashboard` | `frontend.account.dashboard` | `auth` |
| `GET` | `/account/orders` | `Frontend\CustomerAccountController@orders` | `frontend.account.orders` | `auth` |
| `GET` | `/account/orders/{order_number}` | `Frontend\CustomerAccountController@showOrder` | `frontend.account.orders.show` | `auth` |
| `POST` | `/account/orders/{order_number}/cancel` | `Frontend\CustomerAccountController@cancelOrder` | `frontend.account.orders.cancel` | `auth` |
| `GET` | `/account/addresses` | `Frontend\CustomerAccountController@addresses` | `frontend.account.addresses` | `auth` |
| `POST` | `/account/addresses` | `Frontend\CustomerAccountController@storeAddress` | `frontend.account.addresses.store` | `auth` |
| `DELETE` | `/account/addresses/{address}` | `Frontend\CustomerAccountController@deleteAddress` | `frontend.account.addresses.delete` | `auth` |
| `GET` | `/account/wishlist` | `Frontend\WishlistController@index` | `frontend.account.wishlist` | `auth` |
| `POST` | `/products/{product}/reviews` | `Frontend\ProductReviewController@store` | `frontend.products.reviews.store` | `auth` |

---

### ⚙️ 3. Admin Operations Portal Routes (`routes/admin.php`)

*All admin routes are protected by `auth` and `role:admin,editor,author` middleware.*

| Method | Path | Controller & Action | Route Name | Purpose |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/admin` | `Admin\DashboardController@index` | `admin.dashboard` | Admin operational overview & KPI metrics. |
| `RESOURCE` | `/admin/users` | `Admin\UserController` (`index`, `show`, `edit`, `update`) | `admin.users.*` | User management & role assignment. |
| `RESOURCE` | `/admin/pages` | `Admin\PageController` (Full CRUD) | `admin.pages.*` | Dynamic page CMS manager with system locks. |
| `GET` | `/admin/contact-messages` | `Admin\ContactMessageController@index` | `admin.contact-messages.index` | View customer inquiry messages. |
| `GET` | `/admin/contact-messages/{message}` | `Admin\ContactMessageController@show` | `admin.contact-messages.show` | Inspect message details. |
| `PATCH` | `/admin/contact-messages/{message}/status` | `Admin\ContactMessageController@updateStatus` | `admin.contact-messages.update-status` | Update message status (`unread`, `replied`, `archived`). |
| `DELETE` | `/admin/contact-messages/{message}` | `Admin\ContactMessageController@destroy` | `admin.contact-messages.destroy` | Delete contact inquiry. |
| `RESOURCE` | `/admin/products` | `Admin\ProductController` (Full CRUD) | `admin.products.*` | Product catalog CRUD. |
| `RESOURCE` | `/admin/product-categories` | `Admin\ProductCategoryController` (Full CRUD) | `admin.product-categories.*` | Product category manager. |
| `RESOURCE` | `/admin/product-collections` | `Admin\ProductCollectionController` (`index`, `store`, `destroy`) | `admin.product-collections.*` | Curated product collections manager. |
| `GET` | `/admin/inventory` | `Admin\InventoryController@index` | `admin.inventory.index` | Stock audit log & inventory movements. |
| `GET` | `/admin/orders` | `Admin\OrderController@index` | `admin.orders.index` | Order management dashboard. |
| `GET` | `/admin/orders/{order}` | `Admin\OrderController@show` | `admin.orders.show` | Order fulfillment details & line items. |
| `POST` | `/admin/orders/{order}/status` | `Admin\OrderController@updateStatus` | `admin.orders.update-status` | Update order status (`Pending` ➔ `Processing` ➔ `Shipped` ➔ `Delivered` ➔ `Cancelled`). |
| `RESOURCE` | `/admin/coupons` | `Admin\CouponController` (`index`, `store`, `destroy`) | `admin.coupons.*` | Discount coupon generator & manager. |
| `GET` | `/admin/reviews` | `Admin\ProductReviewController@index` | `admin.reviews.index` | Review moderation queue. |
| `POST` | `/admin/reviews/{review}/status` | `Admin\ProductReviewController@updateStatus` | `admin.reviews.update-status` | Approve or hide product review. |
| `DELETE` | `/admin/reviews/{review}` | `Admin\ProductReviewController@destroy` | `admin.reviews.destroy` | Delete product review. |
| `RESOURCE` | `/admin/shipping-methods` | `Admin\ShippingMethodController` (`index`, `store`, `update`, `destroy`) | `admin.shipping-methods.*` | Shipping method & fee rules engine. |
| `POST` | `/admin/plants/{plant}/duplicate` | `Admin\PlantController@duplicate` | `admin.plants.duplicate` | Duplicate encyclopedia plant entry. |
| `RESOURCE` | `/admin/plants` | `Admin\PlantController` (Except `show`) | `admin.plants.*` | Encyclopedia entries manager. |
| `RESOURCE` | `/admin/plant-categories` | `Admin\PlantCategoryController` (Except `show`) | `admin.plant-categories.*` | Plant category taxonomy manager. |
| `RESOURCE` | `/admin/plant-problems` | `Admin\PlantProblemController` (Except `show`) | `admin.plant-problems.*` | Plant Doctor diagnostic manager. |
| `POST` | `/admin/posts/{post}/duplicate` | `Admin\PostController@duplicate` | `admin.posts.duplicate` | Duplicate article/guide post. |
| `GET` | `/admin/posts/{post}/preview` | `Admin\PostController@preview` | `admin.posts.preview` | Live preview for author post drafts. |
| `RESOURCE` | `/admin/posts` | `Admin\PostController` (Except `show`) | `admin.posts.*` | Editorial post CRUD suite. |
| `RESOURCE` | `/admin/content-categories` | `Admin\ContentCategoryController` (Except `show`) | `admin.content-categories.*` | Editorial category manager. |
| `RESOURCE` | `/admin/tags` | `Admin\TagController` (`index`, `store`, `update`, `destroy`) | `admin.tags.*` | Tagging taxonomy manager. |
| `GET` | `/admin/media` | `Admin\MediaController@index` | `admin.media.index` | Central media library dashboard. |
| `POST` | `/admin/media` | `Admin\MediaController@store` | `admin.media.store` | Upload media asset. |
| `PUT` | `/admin/media/{media}` | `Admin\MediaController@update` | `admin.media.update` | Update media alt text & title. |
| `DELETE` | `/admin/media/{media}` | `Admin\MediaController@destroy` | `admin.media.destroy` | Delete media asset. |
| `GET` | `/admin/settings` | `Admin\SettingsController@index` | `admin.settings.index` | System settings manager. |
| `POST` | `/admin/settings` | `Admin\SettingsController@update` | `admin.settings.update` | Save system setting key-values. |
| `GET` | `/admin/newsletter-subscribers` | `Admin\NewsletterSubscriberController@index` | `admin.subscribers.index` | View newsletter subscribers. |
| `DELETE` | `/admin/newsletter-subscribers/{subscriber}` | `Admin\NewsletterSubscriberController@destroy` | `admin.subscribers.destroy` | Unsubscribe customer email. |

---

## ⚙️ System Requirements & Package Manifest

### Technical Requirements
- **PHP**: `^8.2` or `^8.4` (Required extensions: `pdo`, `mbstring`, `openssl`, `gd`, `fileinfo`, `tokenizer`, `xml`)
- **Composer**: `^2.2`+
- **Node.js**: `^18.0` or `^20.0`+
- **Database Engine**: MySQL `^8.0` or SQLite `^3.35`+

### 📦 PHP & Laravel Dependencies (`composer.json`)
- **Framework**: `laravel/framework ^12.0`
- **CLI Shell**: `laravel/tinker ^2.10.1`
- **Development & Testing Suite**:
  - `fakerphp/faker ^1.23` — Realistic seed data generation
  - `laravel/pail ^1.2.2` — Real-time log tailing
  - `laravel/pint ^1.24` — PHP Code Standards fixer
  - `laravel/sail ^1.41` — Docker container execution environment
  - `mockery/mockery ^1.6` — Object mocking framework
  - `nunomaduro/collision ^8.6` — CLI error reporting
  - `phpunit/phpunit ^11.5.50` — Unit & Integration testing suite

### 🎨 Frontend & Build Tooling (`package.json`)
- **Build Engine**: `vite ^7.0.7` with `laravel-vite-plugin ^2.0.0`
- **CSS Architecture**: `@tailwindcss/vite ^4.0.0` & `tailwindcss ^4.0.0`
- **HTTP Client**: `axios ^1.11.0`
- **Process Manager**: `concurrently ^9.0.1`

---

## 🚀 Quickstart Setup & Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/huziee/plant-marketplace.git
   cd plant-marketplace
   ```

2. **Install PHP & Node Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment Settings**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Configure your `.env` database parameters (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).*

4. **Run Migrations & Seed Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Link Storage & Compile Assets**
   ```bash
   php artisan storage:link
   npm run build
   ```

6. **Launch Development Environment**
   ```bash
   # Option A: Run via Composer script (Launches artisan server, queue worker, pail logs & vite concurrently)
   composer dev

   # Option B: Launch manually
   php artisan serve
   npm run dev
   ```

7. **Open Application**
   - **Frontend Storefront**: `http://127.0.0.1:8000` (or `http://plantaric.test`)
   - **Admin Portal**: `http://127.0.0.1:8000/admin`

---

## 🔑 Default Seeded User Credentials

Executing `php artisan db:seed` provisions three default user accounts:

| User Role | Email Address | Default Password | Granted Access Level |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@plantaric.com` | `password` | Full system access, order management, settings & database administration. |
| **Editor** | `editor@plantaric.com` | `password` | Content editing, encyclopedia entries, reviews & product management. |
| **Customer** | `customer@plantaric.com` | `password` | Storefront shopping, cart checkout, account dashboard & order history. |

---

## 📁 Repository Directory Structure

```
plant-marketplace/
├── app/
│   ├── Helpers/            # Custom helper functions (e.g., settings helper)
│   ├── Http/
│   │   ├── Controllers/    # Admin, Auth & Frontend Controllers (39 Controllers)
│   │   └── Middleware/     # Role-based authorization middleware
│   └── Models/             # 43 Eloquent Data Models
├── database/
│   ├── factories/          # Eloquent model factories
│   ├── migrations/         # Database migration definitions
│   └── seeders/            # Database seeders (Pages, Plants, Products, Seeders)
├── public/
│   ├── build/              # Compiled Vite production assets
│   ├── images/             # Product table photography, category covers & brand logos
│   ├── favicon.ico         # Multi-size ICO favicon suite
│   ├── favicon.svg         # Vector SVG favicon
│   └── site.webmanifest    # Web Application PWA manifest
├── resources/
│   ├── css/                # App CSS (Tailwind v4.0 & custom design tokens)
│   ├── js/                 # JavaScript app entrypoints
│   └── views/              # Blade template ecosystem
│       ├── admin/          # Admin CRUD, CMS Page & Contact Inbox management views
│       ├── auth/           # Login, registration, & password reset templates
│       ├── components/     # Reusable UI Blade components (e.g., ad slots)
│       ├── errors/         # Custom HTTP error status pages (404, 403, 500, 419)
│       ├── frontend/       # Storefront, encyclopedia, plant doctor & article views
│       └── layouts/        # Base layout HTML wrappers & partials (drawer, modals, cookie consent)
├── routes/
│   ├── admin.php           # Protected Admin routes (`/admin/*`)
│   ├── console.php         # Artisan CLI commands
│   └── web.php             # Public & Customer routes
├── storage/                # Logs, uploads & cached data
├── composer.json           # PHP package manifest & dev scripts
├── package.json            # Node.js dependencies & scripts
├── vite.config.js          # Vite build config
└── README.md               # Complete System Documentation
```

---

## 📜 License

The Plantaric application is open-source software licensed under the [MIT License](LICENSE).

