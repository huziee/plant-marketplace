<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantFeedLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel',
        'trigger_type',
        'status',
        'items_count',
        'ip_address',
        'user_agent',
        'message',
    ];
}
