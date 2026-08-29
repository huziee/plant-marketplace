<?php

namespace App\Services\SEO;

class SeoService
{
    protected string $title;
    protected string $description;
    protected ?string $canonical = null;
    protected string $robots = 'index, follow';
    protected ?string $ogTitle = null;
    protected ?string $ogDescription = null;
    protected ?string $ogImage = null;
    protected string $twitterCard = 'summary_large_image';
    protected ?array $jsonLd = null;

    public function __construct()
    {
        $this->title = setting('seo_title', 'Plantora — Plants, Nurseries & Garden Care');
        $this->description = setting('seo_description', 'Discover plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert growing advice.');
        $this->ogImage = setting('og_image', asset('images/plantora-og.jpg'));
    }

    public function setJsonLd(array $schema): self
    {
        $this->jsonLd = $schema;
        return $this;
    }

    public function getJsonLd(): ?array
    {
        return $this->jsonLd;
    }

    public function generate(string $title, string $description, ?string $canonical = null, ?string $ogImage = null): array
    {
        $this->setTitle($title)->setDescription($description);
        if ($canonical) {
            $this->setCanonical($canonical);
        }
        if ($ogImage) {
            $this->setOgImage($ogImage);
        }

        return [
            'title' => $this->title,
            'description' => $this->description,
            'canonical' => $this->canonical,
            'og_image' => $this->ogImage,
        ];
    }

    public function setTitle(string $title): self
    {
        $siteName = setting('site_name', 'Plantora');
        $this->title = str_contains($title, $siteName) ? $title : "{$title} | {$siteName}";
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setCanonical(string $url): self
    {
        $this->canonical = $url;
        return $this;
    }

    public function setRobots(string $robots): self
    {
        $this->robots = $robots;
        return $this;
    }

    public function setOgImage(string $imageUrl): self
    {
        $this->ogImage = $imageUrl;
        return $this;
    }

    public function renderTags(): string
    {
        $canonicalUrl = $this->canonical ?? url()->current();
        $ogTitle = e($this->ogTitle ?? $this->title);
        $ogDescription = e($this->ogDescription ?? $this->description);
        $title = e($this->title);
        $description = e($this->description);
        $robots = e($this->robots);
        $ogImage = e($this->ogImage);

        return <<<HTML
        <title>{$title}</title>
        <meta name="description" content="{$description}" />
        <meta name="robots" content="{$robots}" />
        <link rel="canonical" href="{$canonicalUrl}" />

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{$canonicalUrl}" />
        <meta property="og:title" content="{$ogTitle}" />
        <meta property="og:description" content="{$ogDescription}" />
        <meta property="og:image" content="{$ogImage}" />

        <!-- Twitter -->
        <meta name="twitter:card" content="{$this->twitterCard}" />
        <meta name="twitter:title" content="{$ogTitle}" />
        <meta name="twitter:description" content="{$ogDescription}" />
        <meta name="twitter:image" content="{$ogImage}" />
        HTML;
    }
}
