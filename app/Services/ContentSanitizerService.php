<?php

namespace App\Services;

class ContentSanitizerService
{
    /**
     * Allowed HTML tags for editorial content.
     */
    protected array $allowedTags = [
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'p', 'br', 'hr',
        'strong', 'b', 'em', 'i', 'u', 's', 'strike',
        'ul', 'ol', 'li',
        'blockquote', 'pre', 'code',
        'a', 'img', 'span', 'div',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td',
        'figure', 'figcaption',
    ];

    /**
     * Sanitize rich text HTML content safely.
     */
    public function sanitize(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        // 1. Strip script tags and inline javascript event handlers
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
        $html = preg_replace('/on\w+="[^"]*"/i', '', $html);
        $html = preg_replace("/on\w+='[^']*'/i", '', $html);
        $html = preg_replace('/javascript:[^\s"\'<>]+/i', '', $html);

        // 2. Filter allowed tags using strip_tags
        $allowedTagString = '<' . implode('><', $this->allowedTags) . '>';
        $cleaned = strip_tags($html, $allowedTagString);

        // 3. Remove inline styles containing position:fixed or dangerous CSS
        $cleaned = preg_replace('/style="[^"]*expression\([^"]*\)"/i', '', $cleaned);

        return $cleaned;
    }
}
