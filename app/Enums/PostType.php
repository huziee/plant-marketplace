<?php

namespace App\Enums;

enum PostType: string
{
    case ARTICLE = 'article';
    case GUIDE = 'guide';
    case NEWS = 'news';

    public function label(): string
    {
        return match ($this) {
            self::ARTICLE => 'Article',
            self::GUIDE => 'Guide',
            self::NEWS => 'News',
        };
    }

    public function routePrefix(): string
    {
        return match ($this) {
            self::ARTICLE => 'articles',
            self::GUIDE => 'guides',
            self::NEWS => 'news',
        };
    }
}
