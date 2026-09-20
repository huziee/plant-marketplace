<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Content Automation Schedules
Schedule::command('content:discover-news')
    ->hourly()
    ->withoutOverlapping();

Schedule::command('content:discover-articles')
    ->daily()
    ->withoutOverlapping();

Schedule::command('content:generate')
    ->dailyAt('06:00')
    ->withoutOverlapping();
