<?php

namespace App\Services\SEO;

use Illuminate\Support\Str;

class SeoService
{
    protected string $title;
    protected string $description;
    protected ?string $canonical = null;
    protected string $robots = 'index,follow,max-image-preview:large';
    protected ?string $ogTitle = null;
    protected ?string $ogDescription = null;
    protected ?string $ogImage = null;
    protected ?string $ogUrl = null;
    protected string $ogType = 'website';
    protected string $twitterCard = 'summary_large_image';
    protected ?string $twitterTitle = null;
    protected ?string $twitterDescription = null;
    protected ?string $twitterImage = null;
    protected array $jsonLdSchemas = [];

    public function __construct()
    {
        $siteName = setting('site_name', 'Plantaric');
        $defaultTitle = setting('seo_title', 'Plantaric — Agriculture, Plants & Botanical Care');
        $defaultDescription = setting('seo_description', 'Discover agricultural plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert botanical advice.');
        
        $this->title = str_contains($defaultTitle, $siteName) ? $defaultTitle : "{$defaultTitle} | {$siteName}";
        $this->description = Str::limit(strip_tags($defaultDescription), 160, '');
        $this->ogImage = setting('og_image', asset('images/plantaric-og.jpg'));
    }

    public function setTitle(string $title): self
    {
        $siteName = setting('site_name', 'Plantaric');
        $cleanTitle = trim(strip_tags($title));
        $this->title = str_contains($cleanTitle, $siteName) ? $cleanTitle : "{$cleanTitle} | {$siteName}";
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description): self
    {
        $this->description = Str::limit(trim(strip_tags($description)), 160, '');
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setCanonical(?string $url): self
    {
        $this->canonical = $url;
        return $this;
    }

    public function getCanonical(): string
    {
        if ($this->canonical) {
            return $this->canonical;
        }

        // Generate clean canonical by stripping tracking and filter query parameters
        $url = request()->url();
        
        // Handle pagination cleanly if present
        if (request()->has('page') && (int) request()->input('page') > 1) {
            return $url . '?page=' . (int) request()->input('page');
        }

        return $url;
    }

    public function setRobots(string $robots): self
    {
        $this->robots = $robots;
        return $this;
    }

    public function getRobots(): string
    {
        return $this->robots;
    }

    public function setOgTitle(?string $title): self
    {
        $this->ogTitle = $title ? trim(strip_tags($title)) : null;
        return $this;
    }

    public function setOgDescription(?string $description): self
    {
        $this->ogDescription = $description ? Str::limit(trim(strip_tags($description)), 200, '') : null;
        return $this;
    }

    public function setOgImage(?string $imageUrl): self
    {
        $this->ogImage = $imageUrl;
        return $this;
    }

    public function setOgUrl(?string $url): self
    {
        $this->ogUrl = $url;
        return $this;
    }

    public function setOgType(string $type): self
    {
        $this->ogType = $type;
        return $this;
    }

    public function setTwitterCard(string $card): self
    {
        $this->twitterCard = $card;
        return $this;
    }

    public function setTwitterTitle(?string $title): self
    {
        $this->twitterTitle = $title ? trim(strip_tags($title)) : null;
        return $this;
    }

    public function setTwitterDescription(?string $description): self
    {
        $this->twitterDescription = $description ? Str::limit(trim(strip_tags($description)), 200, '') : null;
        return $this;
    }

    public function setTwitterImage(?string $image): self
    {
        $this->twitterImage = $image;
        return $this;
    }

    public function setJsonLd(array $schema): self
    {
        $this->jsonLdSchemas = [$schema];
        return $this;
    }

    public function addJsonLd(array $schema): self
    {
        $this->jsonLdSchemas[] = $schema;
        return $this;
    }

    public function getJsonLdSchemas(): array
    {
        return $this->jsonLdSchemas;
    }

    public function getGoogleAnalyticsId(): ?string
    {
        return env('GOOGLE_ANALYTICS_ID') ?: setting('google_analytics_id');
    }

    public function getGoogleSiteVerification(): ?string
    {
        return env('GOOGLE_SITE_VERIFICATION') ?: setting('google_site_verification');
    }

    /**
     * Populate SEO parameters directly from Eloquent model with fallbacks.
     */
    public function forModel(object $model, ?string $fallbackTitle = null, ?string $fallbackDescription = null): self
    {
        $title = $model->seo_title ?? $model->meta_title ?? $fallbackTitle ?? $model->name ?? $model->title ?? null;
        if ($title) {
            $this->setTitle($title);
        }

        $description = $model->meta_description ?? $fallbackDescription ?? $model->short_description ?? $model->excerpt ?? $model->description ?? null;
        if ($description) {
            $this->setDescription($description);
        }

        if (!empty($model->canonical_url)) {
            $this->setCanonical($model->canonical_url);
        }

        if (isset($model->robots_index) && !$model->robots_index) {
            $robotsFollow = ($model->robots_follow ?? true) ? 'follow' : 'nofollow';
            $this->setRobots("noindex,{$robotsFollow}");
        } elseif (isset($model->robots_follow) && !$model->robots_follow) {
            $this->setRobots("index,nofollow,max-image-preview:large");
        }

        $ogTitle = $model->og_title ?? $title;
        if ($ogTitle) {
            $this->setOgTitle($ogTitle);
        }

        $ogDescription = $model->og_description ?? $description;
        if ($ogDescription) {
            $this->setOgDescription($ogDescription);
        }

        if (!empty($model->ogImage) && !empty($model->ogImage->file_path)) {
            $this->setOgImage(asset('storage/' . $model->ogImage->file_path));
        } elseif (!empty($model->featuredImage) && !empty($model->featuredImage->file_path)) {
            $this->setOgImage(asset('storage/' . $model->featuredImage->file_path));
        }

        return $this;
    }

    public function renderTags(): string
    {
        $rawTitle = htmlspecialchars_decode($this->getTitle(), ENT_QUOTES);
        $title = e($rawTitle);
        $description = e($this->getDescription());
        $canonicalUrl = e($this->getCanonical());
        $robots = e($this->getRobots());

        $ogTitle = e(htmlspecialchars_decode($this->ogTitle ?? $this->getTitle(), ENT_QUOTES));
        $ogDescription = e($this->ogDescription ?? $this->getDescription());
        $ogUrl = e($this->ogUrl ?? $this->getCanonical());
        $ogImage = e($this->ogImage ?? setting('og_image', asset('images/plantaric-og.jpg')));
        $ogType = e($this->ogType);

        $twitterCard = e($this->twitterCard);
        $twitterTitle = e(htmlspecialchars_decode($this->twitterTitle ?? $ogTitle, ENT_QUOTES));
        $twitterDescription = e($this->twitterDescription ?? $ogDescription);
        $twitterImage = e($this->twitterImage ?? $ogImage);

        $html = [];
        $html[] = "<title>{$rawTitle}</title>";
        $html[] = "<meta name=\"description\" content=\"{$description}\">";
        $html[] = "<link rel=\"canonical\" href=\"{$canonicalUrl}\">";
        $html[] = "<meta name=\"robots\" content=\"{$robots}\">";

        // Open Graph
        $html[] = "<meta property=\"og:title\" content=\"{$ogTitle}\">";
        $html[] = "<meta property=\"og:description\" content=\"{$ogDescription}\">";
        $html[] = "<meta property=\"og:url\" content=\"{$ogUrl}\">";
        $html[] = "<meta property=\"og:image\" content=\"{$ogImage}\">";
        $html[] = "<meta property=\"og:type\" content=\"{$ogType}\">";
        $html[] = "<meta property=\"og:site_name\" content=\"" . e(setting('site_name', 'Plantaric')) . "\">";

        // Twitter
        $html[] = "<meta name=\"twitter:card\" content=\"{$twitterCard}\">";
        $html[] = "<meta name=\"twitter:title\" content=\"{$twitterTitle}\">";
        $html[] = "<meta name=\"twitter:description\" content=\"{$twitterDescription}\">";
        $html[] = "<meta name=\"twitter:image\" content=\"{$twitterImage}\">";

        // Google Search Console Verification
        $siteVerification = $this->getGoogleSiteVerification();
        if (!empty($siteVerification)) {
            $html[] = "<meta name=\"google-site-verification\" content=\"" . e($siteVerification) . "\">";
        }

        // Google Analytics (GA4)
        $gaId = $this->getGoogleAnalyticsId();
        if (!empty($gaId)) {
            $gaIdEscaped = e($gaId);
            $html[] = "<!-- Google Analytics GA4 -->";
            $html[] = "<script async src=\"https://www.googletagmanager.com/gtag/js?id={$gaIdEscaped}\"></script>";
            $html[] = "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{$gaIdEscaped}');</script>";
        }

        // JSON-LD Scripts
        foreach ($this->jsonLdSchemas as $schema) {
            if (!empty($schema)) {
                $json = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                if ($json) {
                    $html[] = "<script type=\"application/ld+json\">\n{$json}\n</script>";
                }
            }
        }

        return implode("\n    ", $html);
    }
}
