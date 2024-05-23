<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Session;
use App\Models\Discounts;




Artisan::command('reload', function () {
    DB::table('discounts')->insert([
        'discount' => 20,
        'quantity' => 100,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
})->dailyAt('09:00');
