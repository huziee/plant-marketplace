<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case REVIEW = 'review';
    case SCHEDULED = 'scheduled';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::REVIEW => 'In Review',
            self::SCHEDULED => 'Scheduled',
            self::PUBLISHED => 'Published',
            self::ARCHIVED => 'Archived',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-secondary',
            self::REVIEW => 'bg-warning text-dark',
            self::SCHEDULED => 'bg-info text-dark',
            self::PUBLISHED => 'bg-success',
            self::ARCHIVED => 'bg-dark',
        };
    }
}
