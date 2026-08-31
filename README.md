<p align="center">
  <img src="public/images/plantaric-logo.png" width="480" alt="Plantaric Logo">
</p>

<h1 align="center">Plantaric — E-Commerce Marketplace & Botanical Encyclopedia Platform</h1>

<p align="center">
  <b>A comprehensive, full-stack Laravel 12 application combining a modern plant marketplace, botanical encyclopedia, diagnostic plant doctor, CMS legal page manager, and multi-author editorial publishing platform.</b>
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

**Plantaric** is an all-in-one web application designed for botanical e-commerce businesses, online nurseries, agricultural brands, and plant care communities. The platform integrates:
- **E-Commerce Marketplace**: Full product catalog, variants, custom attributes, cart drawer, discount coupon engine, dynamic shipping calculation, checkout flow, order tracking, and customer address management.
- **Botanical Encyclopedia**: Detailed plant species directory complete with scientific taxonomy, pet toxicity warnings, light/water schedules, soil requirements, and seasonal care guides.
- **Plant Doctor Diagnostic Center**: Interactive symptom-to-treatment lookup system for plant diseases, pests, fungal infections, and nutrient deficiencies.
- **Editorial Publishing System**: Rich multi-author blogging engine for botanical articles, step-by-step growing guides, and plant news.
- **Page CMS & Trust Pages**: Dynamic CMS for legal policies (*Privacy Policy*, *Terms & Conditions*, *Cookie Policy*, *Shipping*, *Returns*) and company pages (*About Us*, *Contact Us*) with system-page lock protection.
- **Contact Inbox & Spam Shield**: Secure customer contact form featuring honeypot anti-spam protection, unread status indicators, and admin reply history.
- **Admin Operations Dashboard**: Role-Based Access Control (RBAC) portal managing products, stock movements, order processing, coupon rules, plant entries, review moderation, media assets, CMS pages, and site configurations.

---

## 🏗️ System Architecture

```mermaid
graph TD
    User([Public Visitor / Customer]) --> Frontend[Frontend Store & Content Engine]
    Admin([Admin / Editor / Author]) --> AdminPanel[Admin Operations Portal]

    subgraph Frontend Subsystems
        Frontend --> Shop[Shop Catalog & Product Pages]
        Frontend --> CartCheckout[Cart Drawer & Checkout Flow]
        Frontend --> PlantDB[Botanical Encyclopedia]
        Frontend --> PlantDoc[Plant Doctor Diagnostics]
        Frontend --> Content[Articles, Guides & Newsroom]
        Frontend --> Account[Customer Dashboard & Orders]
    end

    subgraph Admin Operations
        AdminPanel --> Inventory[Inventory & Stock Movement]
        AdminPanel --> OrderMgmt[Order Status & Fulfillment]
        AdminPanel --> CouponEngine[Coupon & Discount Rules]
        AdminPanel --> ContentMgmt[Post & Encyclopedia Editor]
        AdminPanel --> ReviewMod[Review Moderation Queue]
        AdminPanel --> SystemSettings[Dynamic Key-Value Settings]
    end

    subgraph Database Layer
        Shop & CartCheckout & PlantDB & PlantDoc & Content & Account --> DB[(MySQL / SQLite Database)]
        Inventory & OrderMgmt & CouponEngine & ContentMgmt & ReviewMod & SystemSettings --> DB
    end
```

---

## ✨ Exhaustive Feature Matrix

### 🛒 1. E-Commerce Marketplace & Checkout Engine

| Feature | Technical Description |
| :--- | :--- |
| **Product Catalog (`/shop`)** | Searchable grid with category filtering, price sliders, stock availability filters, and sorting options (Price Low-to-High, High-to-Low, Latest, Top Rated). |
| **Product Variants & Attributes** | Dynamic support for multi-variant products (e.g., Pot Color, Size, Package Weight) backed by `ProductVariant`, `ProductAttribute`, and `ProductAttributeValue`. |
| **Product Gallery & Media** | Multi-image product showcases powered by `ProductImage` with primary image flags and optimized thumbnail loading. |
| **Real-Time Cart Drawer & Cart Page** | Slide-over cart drawer and full `/cart` page with line-item quantity controls, subtotal auto-calculations, and persistent database/session cart state. |
| **Discount & Coupon Engine** | Percentage-based or fixed-amount promotional codes with expiration dates, minimum spending thresholds, usage caps per user, and redemptions ledger (`coupons`, `coupon_usages`). |
| **Dynamic Shipping Methods** | Configurable shipping providers (Flat Rate, Express, Free Shipping Thresholds, Nursery Pickup) calculated dynamically during checkout (`shipping_methods`). |
| **Multi-Step Checkout (`/checkout`)** | Address selection, dynamic fee calculation, instant order creation with unique tracking identifiers (`PLN-YYYYMMDD-XXXX`), and order status history logging. |
| **Product Reviews & Ratings** | Star ratings (1–5 scale), text reviews, customer verification badges, and an admin moderation workflow (`product_reviews`). |
| **Customer Wishlist** | Instant AJAX wishlist toggling for registered customers with persistence across sessions (`wishlists`). |

---

### 🪴 2. Botanical Encyclopedia (`/plants`)

| Feature | Technical Description |
| :--- | :--- |
| **Species Directory** | Comprehensive plant catalog with scientific taxonomy, plant family, geographic origin, growth rate, mature height, and toxicity/pet-safety alerts. |
| **Care Requirement Matrix** | Granular data model (`plant_cares`) tracking: ☀️ Light intensity & window placement, 💧 Watering frequency & humidity %, 🧪 Soil mixture & pH range, 🌡️ Min/max temperature tolerance, 🌿 Fertilizer type & feeding schedule, ✂️ Pruning & repotting frequency. |
| **Common Names & Synonyms** | Multi-alias index (`plant_common_names`) allowing users to find plants via local or regional names (e.g., *Monstera deliciosa* vs. *Swiss Cheese Plant*). |
| **Seasonal Care Guides** | Customized growing routines for Spring, Summer, Autumn, and Winter growth cycles (`plant_seasons`). |

---

### 🩺 3. Plant Doctor Diagnostic Portal (`/plant-problems`)

| Feature | Technical Description |
| :--- | :--- |
| **Symptom Lookup** | Visual diagnostic index for plant leaf discoloration, pest infestation, root rot, fungal spots, and wilting (`plant_problems`). |
| **Pathogen & Cause Breakdown** | In-depth cause analysis (`plant_problem_causes`) identifying viral, bacterial, fungal, insect, or environmental stress roots. |
| **Multi-Tier Treatment Plans** | Step-by-step recovery steps (`plant_problem_treatments`) divided into Organic Remedies, Chemical Treatments, and Culture Adjustments. |
| **Prevention & Affected Species** | Preventive maintenance guidelines (`plant_problem_preventions`) linked directly to vulnerable host plant species. |

---

### 📰 4. Multi-Author Editorial Engine (`/articles`, `/guides`, `/news`)

| Feature | Technical Description |
| :--- | :--- |
| **Content Publishing Suite** | Manage Botanical Articles, Step-by-Step Growing Tutorials, and Industry News with rich text, featured images, reading time estimates, and publication states. |
| **Taxonomy & Tagging** | Content categorization (`content_categories`) and cross-referencing tags (`tags`) for optimal content discoverability. |
| **Author Profiles** | Author profile bios, avatars, social links, and dedicated author archive pages (`/authors/{id}`). |
| **SEO & Schema Markup** | Built-in JSON-LD microdata formatting (`Article`, `NewsArticle`, `Product`, `Organization`) for Google Rich Snippets. |

---

### 📄 5. CMS Page Engine & Trust Documentation

| Feature | Technical Description |
| :--- | :--- |
| **Dynamic Page CMS (`/admin/pages`)** | Full CRUD page manager to edit, publish, and structure static pages (`pages` table) with custom meta titles and descriptions. |
| **System Page Lock (`is_system`)** | Core legal policies (`privacy-policy`, `terms-and-conditions`, `disclaimer`, `cookie-policy`) have deletion and slug mutation locks to preserve routing integrity. |
| **10 Seeded Public Pages** | Seeded templates for `/about-us`, `/contact-us`, `/privacy-policy`, `/terms-and-conditions`, `/cookie-policy`, `/disclaimer`, `/editorial-policy`, `/shipping-policy`, `/return-refund-policy`, `/advertising-disclosure`. |
| **Honeypot Anti-Spam Shield** | Contact form features a hidden honeypot input field (`website`) to automatically trap and reject automated bot submissions without database pollution. |
| **Contact Message Inbox (`/admin/contact-messages`)** | Admin panel to review incoming customer messages, track reply statuses (`unread`, `replied`, `archived`), and log response notes. |

---

### 🖼️ 6. Visual Asset System & Realistic Photography

| Feature | Technical Description |
| :--- | :--- |
| **Desk & Table Product Imagery** | Ultra-realistic 4K studio product photos of indoor plants placed on wooden desks and side tables (`public/images/products/*_table.jpg`). |
| **Curated Category Imagery** | High-definition custom category cover photos for Indoor Plants, Outdoor Plants, Flowering Plants, Succulents & Cacti, Kitchen Herbs, and Vegetables (`public/images/categories/*.jpg`). |
| **Fallback Asset Resolver** | Fallback mapping logic in `HomeController` ensuring every featured product and category card renders a distinct visual asset. |

---

### 👤 7. Customer Account Portal (`/account`)

| Feature | Technical Description |
| :--- | :--- |
| **Account Dashboard** | Centralized dashboard displaying order history stats, default shipping address, and recent wishlist additions. |
| **Order History & Management** | Detail views (`/account/orders/{order_number}`) showing line items, pricing breakdown, shipping tracking, and order cancellation capability for pending orders. |
| **Address Book** | Full CRUD address manager (`customer_addresses`) supporting default billing and shipping address flags. |

---

### ⚙️ 8. Admin Operations Portal (`/admin`)

| Feature | Technical Description |
| :--- | :--- |
| **Role-Based Security** | Protected by `role:admin,editor,author` middleware supporting granular permission checks. |
| **Operations Dashboard** | Key metrics including Total Revenue, Total Orders, Active Products, Customer Count, and Low-Stock Warnings. |
| **Inventory Ledger (`/admin/inventory`)** | Stock tracking with historical audit logs (`inventory_movements`) for stock-ins, sales deductions, and manual adjustments. |
| **Order Management & Status Workflow** | Update order statuses (`Pending` ➔ `Processing` ➔ `Shipped` ➔ `Delivered` ➔ `Cancelled`) with automatic timestamping in `order_status_histories`. |
| **Plant & Problem CMS** | Complete admin interface to create, duplicate, edit, and publish encyclopedia entries and diagnostic problem guides. |
| **Page CMS & Contact Inbox** | Manage static legal documentation and reply to customer inquiries directly from `/admin/contact-messages`. |
| **Review Moderation Queue** | Approve, hide, or remove customer reviews prior to public display. |
| **Media Library (`/admin/media`)** | Central asset manager for media uploads, image resizing, alt text configuration, and file deletion. |
| **Newsletter Lead Directory** | Exportable subscriber directory (`newsletter_subscribers`) captured via footer and homepage opt-in forms. |
| **Dynamic Key-Value Settings Engine** | Manage site name, logo, contact emails, currency symbol, social links, and SEO defaults stored dynamically in the `settings` table. |

---

### 🌐 9. SEO, Performance & System Utilities

| Feature | Technical Description |
| :--- | :--- |
| **Automated XML Sitemaps** | Dynamic index at `/sitemap.xml` with specialized child sitemaps (`/sitemaps/products.xml`, `/sitemaps/plants.xml`, `/sitemaps/posts.xml`). |
| **URL Redirect Engine** | Database-driven 301/302 URL redirection table (`url_redirects`) to preserve SEO authority during route changes. |
| **Complete Favicon Suite** | Multi-size ICO (16x16, 32x32, 48x48, 64x64), SVG vector icon, Apple Touch Icon (180x180), Android Chrome (192x192, 512x512), and `site.webmanifest`. |

---

## 🗄️ Database Schema & Model Directory (43 Entities)

The application database encompasses 43 specialized Eloquent models:

| Entity Group | Model Name | Primary Purpose |
| :--- | :--- | :--- |
| **Core & Users** | `User` | Authentication, RBAC roles (`admin`, `editor`, `author`, `customer`), avatars. |
| | `AuthorProfile` | Public author bios, credentials, and social links. |
| | `CustomerAddress` | Saved customer shipping and billing addresses. |
| **Marketplace** | `Product` | Main product catalog items, prices, SKUs, stock levels, and SEO attributes. |
| | `ProductCategory` | Hierarchical product categories (Indoor Plants, Seeds, Pots, Tools). |
| | `ProductCollection` | Curated product groupings (e.g., Best Sellers, Low Light Favorites). |
| | `ProductVariant` | SKU variations (size, color, pot style). |
| | `ProductAttribute` | Dynamic attribute keys (e.g., Color, Pot Diameter). |
| | `ProductAttributeValue` | Specific attribute option values. |
| | `ProductImage` | Product gallery assets and primary flags. |
| | `ProductReview` | Ratings, feedback text, verified purchase status, and approval flags. |
| **Cart & Orders** | `Cart` | Session or user cart container. |
| | `CartItem` | Line items in cart with quantity and variant selections. |
| | `Order` | Finalized order records with order tracking number, totals, and status. |
| | `OrderItem` | Snapshot of purchased products, unit prices, and quantities. |
| | `OrderStatusHistory` | Historical audit log of order state changes. |
| | `Payment` | Payment transaction records, gateway responses, and status. |
| | `ShippingMethod` | Shipping rate rules, delivery estimates, and free shipping conditions. |
| | `Coupon` | Promo code rules, discount types (% or fixed), caps, and expiry dates. |
| | `CouponUsage` | Audit log tracking redemptions per customer/order. |
| | `InventoryMovement` | Stock adjustment ledger (Stock In, Sale, Return, Adjustment). |
| | `Wishlist` | User product bookmarks. |
| **Plant Encyclopedia**| `Plant` | Plant species profile, scientific taxonomy, pet safety, and growth traits. |
| | `PlantCategory` | Categorization (Succulents, Tropicals, Ferns, Flowering). |
| | `PlantCare` | Precise environmental care parameters (light, water, soil, fertilizer). |
| | `PlantCommonName` | Regional & common aliases for plant lookup. |
| | `PlantImage` | High-res botanical images. |
| | `PlantSeason` | Seasonal growth & dormant care guidelines. |
| **Plant Doctor** | `PlantProblem` | Disease, pest, and condition entries. |
| | `PlantProblemSymptom` | Visual disease indicators & leaf conditions. |
| | `PlantProblemCause` | Biological & environmental root causes. |
| | `PlantProblemTreatment` | Organic and chemical treatment procedures. |
| | `PlantProblemPrevention` | Long-term prevention strategies. |
| **Content Engine** | `Post` | Articles, step-by-step guides, and news items. |
| | `ContentCategory` | Article and news categories. |
| | `Tag` | Tagging system across articles and products. |
| | `PostSource` | Citation sources and external references for research articles. |
| **Page CMS & Trust**| `Page` | CMS legal policy and company pages with `is_system` protection lock. |
| | `ContactMessage` | Customer contact inquiry submissions with honeypot anti-spam verification. |
| **System Utilities** | `Media` | Centralized media library asset records. |
| | `Setting` | Key-value system configuration records. |
| | `NewsletterSubscriber`| Email subscriber leads. |
| | `UrlRedirect` | 301/302 SEO URL redirection map. |

---

## 🛣️ Complete Route Map

### 🌐 Public Frontend & Content Routes

| Verb | Path | Controller & Action | Route Name | Description |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/` | `Frontend\HomeController@index` | `frontend.home` | Homepage with hero, search, categories, popular desk plants grid, plant doctor, guides, and news. |
| `GET` | `/shop` | `Frontend\ShopController@index` | `shop.index` | Public marketplace product catalog with category, price slider, and sorting filters. |
| `GET` | `/shop/category/{slug}` | `Frontend\ShopController@category` | `frontend.shop.category` | Category-specific product showcase. |
| `GET` | `/shop/products/{slug}` | `Frontend\ShopController@show` | `frontend.shop.product` | Detailed product page with gallery, variant selectors, stock badge, and customer reviews. |
| `GET` | `/cart` | `Frontend\CartController@index` | `frontend.cart.index` | Full shopping cart page. |
| `POST` | `/cart/add` | `Frontend\CartController@add` | `frontend.cart.add` | Add product or variant line item to cart. |
| `PUT` | `/cart/items/{id}` | `Frontend\CartController@update` | `frontend.cart.update` | Update line item quantity in cart. |
| `DELETE` | `/cart/items/{id}` | `Frontend\CartController@remove` | `frontend.cart.remove` | Remove line item from cart. |
| `POST` | `/cart/coupon` | `Frontend\CartController@applyCoupon` | `frontend.cart.coupon` | Apply promotional discount code to cart. |
| `DELETE` | `/cart/coupon` | `Frontend\CartController@removeCoupon` | `frontend.cart.coupon.remove` | Remove applied coupon from cart. |
| `GET` | `/plants` | `Frontend\PlantController@index` | `plants.index` | Botanical Encyclopedia species directory. |
| `GET` | `/plants/{plant:slug}` | `Frontend\PlantController@show` | `plants.show` | Detailed plant profile with light, water, soil matrix, pet safety warnings, and seasonal care. |
| `GET` | `/plant-problems` | `Frontend\PlantProblemController@index` | `problems.index` | Plant Doctor diagnostic index. |
| `GET` | `/plant-problems/{plantProblem:slug}` | `Frontend\PlantProblemController@show` | `problems.show` | Symptom, pathogen, multi-tier treatments, and prevention guide. |
| `GET` | `/articles` | `Frontend\ArticleController@index` | `articles.index` | Botanical articles directory. |
| `GET` | `/articles/category/{slug}` | `Frontend\ContentCategoryController@show` | `content-categories.show` | Articles filtered by content category. |
| `GET` | `/articles/{slug}` | `Frontend\ArticleController@show` | `articles.show` | Article post detail view with author profile and JSON-LD schema. |
| `GET` | `/guides` | `Frontend\GuideController@index` | `guides.index` | Step-by-step growing tutorials index. |
| `GET` | `/guides/{slug}` | `Frontend\GuideController@show` | `guides.show` | Detailed growing guide tutorial. |
| `GET` | `/news` | `Frontend\NewsController@index` | `news.index` | Plant and industry newsroom. |
| `GET` | `/news/{slug}` | `Frontend\NewsController@show` | `news.show` | News story detail page. |
| `GET` | `/authors/{user}` | `Frontend\AuthorController@show` | `authors.show` | Author bio archive showing published posts. |
| `GET` | `/about-us` | `Frontend\PageController@about` | `frontend.about` | About Plantaric company overview. |
| `GET` | `/contact-us` | `Frontend\PageController@contact` | `frontend.contact` | Customer support contact page with honeypot spam protection. |
| `POST` | `/contact-us` | `Frontend\PageController@submitContact` | `frontend.contact.submit` | Submit contact message (throttled `5,1` per min). |
| `GET` | `/privacy-policy` | `Frontend\PageController@show` | `frontend.privacy` | Privacy Policy documentation. |
| `GET` | `/terms-and-conditions` | `Frontend\PageController@show` | `frontend.terms` | Terms & Conditions agreement. |
| `GET` | `/cookie-policy` | `Frontend\PageController@show` | `frontend.cookie-policy` | Cookie Consent & Policy document. |
| `GET` | `/disclaimer` | `Frontend\PageController@show` | `frontend.disclaimer` | Plant Care & Medical Disclaimer. |
| `GET` | `/editorial-policy` | `Frontend\PageController@show` | `frontend.editorial-policy` | Botanical Publishing & Review Policy. |
| `GET` | `/shipping-policy` | `Frontend\PageController@show` | `frontend.shipping-policy` | Shipping & Nursery Delivery Policy. |
| `GET` | `/return-refund-policy` | `Frontend\PageController@show` | `frontend.return-refund-policy` | Returns & Plant Health Guarantee Policy. |
| `GET` | `/advertising-disclosure` | `Frontend\PageController@show` | `frontend.advertising-disclosure` | Advertising & Affiliate Disclosure. |
| `GET` | `/page/{slug}` | `Frontend\PageController@show` | `frontend.page.show` | Dynamic CMS page route. |
| `GET` | `/search` | `Frontend\SearchController@index` | `search.index` | Global search across products, plants, guides, and articles. |
| `POST` | `/newsletter/subscribe` | `Frontend\NewsletterController@subscribe` | `newsletter.subscribe` | Join email newsletter. |
| `GET` | `/sitemap.xml` | `Frontend\SitemapController@index` | `sitemap` | Main XML Sitemap index. |
| `GET` | `/sitemaps/{type}.xml` | `Frontend\SitemapController@show` | `sitemap.show` | Specific XML Sitemap (`products`, `plants`, `posts`). |

---

### 🔐 Authentication & Customer Account Routes

| Verb | Path | Controller & Action | Route Name | Middleware |
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

### ⚙️ Admin Operations Routes (`/admin`)

*All admin routes are protected by `auth` and `role:admin,editor,author` middleware.*

| Verb | Path | Controller & Action | Route Name |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin` | `Admin\DashboardController@index` | `admin.dashboard` |
| `RESOURCE` | `/admin/users` | `Admin\UserController` (`index`, `show`, `edit`, `update`) | `admin.users.*` |
| `RESOURCE` | `/admin/pages` | `Admin\PageController` (Full CRUD, CMS Page Manager) | `admin.pages.*` |
| `GET` | `/admin/contact-messages` | `Admin\ContactMessageController@index` | `admin.contact-messages.index` |
| `GET` | `/admin/contact-messages/{message}` | `Admin\ContactMessageController@show` | `admin.contact-messages.show` |
| `PATCH` | `/admin/contact-messages/{message}/status` | `Admin\ContactMessageController@updateStatus` | `admin.contact-messages.update-status` |
| `DELETE` | `/admin/contact-messages/{message}` | `Admin\ContactMessageController@destroy` | `admin.contact-messages.destroy` |
| `RESOURCE` | `/admin/products` | `Admin\ProductController` (Full CRUD) | `admin.products.*` |
| `RESOURCE` | `/admin/product-categories` | `Admin\ProductCategoryController` (Full CRUD) | `admin.product-categories.*` |
| `RESOURCE` | `/admin/product-collections` | `Admin\ProductCollectionController` (`index`, `store`, `destroy`) | `admin.product-collections.*` |
| `GET` | `/admin/inventory` | `Admin\InventoryController@index` | `admin.inventory.index` |
| `GET` | `/admin/orders` | `Admin\OrderController@index` | `admin.orders.index` |
| `GET` | `/admin/orders/{order}` | `Admin\OrderController@show` | `admin.orders.show` |
| `POST` | `/admin/orders/{order}/status` | `Admin\OrderController@updateStatus` | `admin.orders.update-status` |
| `RESOURCE` | `/admin/coupons` | `Admin\CouponController` (`index`, `store`, `destroy`) | `admin.coupons.*` |
| `GET` | `/admin/reviews` | `Admin\ProductReviewController@index` | `admin.reviews.index` |
| `POST` | `/admin/reviews/{review}/status` | `Admin\ProductReviewController@updateStatus` | `admin.reviews.update-status` |
| `DELETE` | `/admin/reviews/{review}` | `Admin\ProductReviewController@destroy` | `admin.reviews.destroy` |
| `RESOURCE` | `/admin/shipping-methods` | `Admin\ShippingMethodController` (`index`, `store`, `update`, `destroy`) | `admin.shipping-methods.*` |
| `POST` | `/admin/plants/{plant}/duplicate` | `Admin\PlantController@duplicate` | `admin.plants.duplicate` |
| `RESOURCE` | `/admin/plants` | `Admin\PlantController` (Except `show`) | `admin.plants.*` |
| `RESOURCE` | `/admin/plant-categories` | `Admin\PlantCategoryController` (Except `show`) | `admin.plant-categories.*` |
| `RESOURCE` | `/admin/plant-problems` | `Admin\PlantProblemController` (Except `show`) | `admin.plant-problems.*` |
| `POST` | `/admin/posts/{post}/duplicate` | `Admin\PostController@duplicate` | `admin.posts.duplicate` |
| `GET` | `/admin/posts/{post}/preview` | `Admin\PostController@preview` | `admin.posts.preview` |
| `RESOURCE` | `/admin/posts` | `Admin\PostController` (Except `show`) | `admin.posts.*` |
| `RESOURCE` | `/admin/content-categories` | `Admin\ContentCategoryController` (Except `show`) | `admin.content-categories.*` |
| `RESOURCE` | `/admin/tags` | `Admin\TagController` (`index`, `store`, `update`, `destroy`) | `admin.tags.*` |
| `GET` | `/admin/media` | `Admin\MediaController@index` | `admin.media.index` |
| `POST` | `/admin/media` | `Admin\MediaController@store` | `admin.media.store` |
| `PUT` | `/admin/media/{media}` | `Admin\MediaController@update` | `admin.media.update` |
| `DELETE` | `/admin/media/{media}` | `Admin\MediaController@destroy` | `admin.media.destroy` |
| `GET` | `/admin/settings` | `Admin\SettingsController@index` | `admin.settings.index` |
| `POST` | `/admin/settings` | `Admin\SettingsController@update` | `admin.settings.update` |
| `GET` | `/admin/newsletter-subscribers` | `Admin\NewsletterSubscriberController@index` | `admin.subscribers.index` |
| `DELETE` | `/admin/newsletter-subscribers/{subscriber}` | `Admin\NewsletterSubscriberController@destroy` | `admin.subscribers.destroy` |

---

## ⚙️ System Requirements & Package Manifest

### System Requirements
- **PHP**: `^8.2` or `^8.4` (required extensions: `pdo`, `mbstring`, `openssl`, `gd`, `fileinfo`)
- **Composer**: `^2.2`+
- **Node.js**: `^18.0` or `^20.0`+
- **Database**: MySQL `^8.0` or SQLite `^3.35`+

### 📦 PHP & Laravel Dependencies (`composer.json`)
- **Framework**: `laravel/framework ^12.0`
- **CLI Shell**: `laravel/tinker ^2.10.1`
- **Development & Testing Tools**:
  - `fakerphp/faker ^1.23` — Test data generation
  - `laravel/pail ^1.2.2` — Real-time log tailing
  - `laravel/pint ^1.24` — PHP code styling
  - `laravel/sail ^1.41` — Docker container environment
  - `mockery/mockery ^1.6` — Mocking objects
  - `nunomaduro/collision ^8.6` — Error reporting
  - `phpunit/phpunit ^11.5.50` — Test suite execution

### 🎨 Frontend & Asset Dependencies (`package.json`)
- **Build Tool**: `vite ^7.0.7` with `laravel-vite-plugin ^2.0.0`
- **CSS Framework**: `@tailwindcss/vite ^4.0.0` & `tailwindcss ^4.0.0`
- **HTTP Client**: `axios ^1.11.0`
- **Process Manager**: `concurrently ^9.0.1`

---

## 🚀 Quickstart Installation Steps

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

3. **Configure Environment File**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Update your `.env` database connection parameters (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).*

4. **Run Database Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

5. **Link Storage Directory & Compile Production Assets**
   ```bash
   php artisan storage:link
   npm run build
   ```

6. **Start Local Development Environment**
   ```bash
   # Option A: Run via Composer dev script (starts server, queue, logs & vite concurrently)
   composer dev

   # Option B: Run commands in separate terminals
   php artisan serve
   npm run dev
   ```

7. **Access the Application**
   - **Frontend Marketplace**: `http://127.0.0.1:8000` (or `http://plantaric.test`)
   - **Admin Operations Dashboard**: `http://127.0.0.1:8000/admin`

---

## 🔑 Default Seeder Credentials

When running `php artisan db:seed`, the system automatically provisions seeded accounts:

| Role | Email | Password | Access Level |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@plantaric.com` | `password` | Full System Access & Settings |
| **Editor** | `editor@plantaric.com` | `password` | Content, Products & Orders |
| **Customer** | `customer@plantaric.com` | `password` | Shopping, Checkout & Account |

---

## 📁 Repository Structure

```
plant-marketplace/
├── app/
│   ├── Helpers/            # Helper functions (e.g., settings helper)
│   ├── Http/
│   │   ├── Controllers/    # Admin, Auth & Frontend Controllers
│   │   └── Middleware/     # Role-based authorization middleware
│   └── Models/             # 43 Eloquent Data Models
├── database/
│   ├── factories/          # Test data factories
│   ├── migrations/         # Database table definitions
│   └── seeders/            # Initial dataset seeders
├── public/
│   ├── build/              # Compiled Vite assets
│   ├── images/             # Product table photography, categories & brand assets
│   ├── favicon.ico         # Multi-size ICO favicon
│   ├── favicon.svg         # SVG Vector favicon
│   └── site.webmanifest    # Web app PWA manifest
├── resources/
│   ├── css/                # App styling (Tailwind CSS v4 & custom tokens)
│   ├── js/                 # JavaScript modules
│   └── views/              # Blade layouts, partials & templates
│       ├── admin/          # Admin CRUD, CMS Page & Contact management panels
│       ├── auth/           # Login, registration, password reset views
│       ├── errors/         # Custom HTTP error pages (404, 403, 500, 419)
│       ├── frontend/       # Storefront, encyclopedia, & article templates
│       └── layouts/        # Base HTML wrappers (app.blade.php, admin.blade.php)
├── routes/
│   ├── admin.php           # Protected Admin routes
│   ├── console.php         # Artisan commands
│   └── web.php             # Public & Customer routes
├── storage/                # App logs, uploads & cache
├── composer.json           # PHP dependencies & scripts
├── package.json            # Node.js dependencies
├── vite.config.js          # Vite build configuration
└── README.md               # System Documentation
```

---

## 📜 License

The Plantaric application is open-source software licensed under the [MIT License](LICENSE).
