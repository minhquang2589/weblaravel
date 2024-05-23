<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Users;
use App\Models\Section_02;
use Illuminate\Support\Facades\Gate;
use App\Http\Middleware\CustomCheckRole;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;



class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */

    public function register(): void
    {
        //
    }
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $userData = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                ];
                if ($user->role == 'admin') {
                    $userData['isAdmin'] = true;
                } else {
                    $userData['isAdmin'] = false;
                }
                session()->put('userData', $userData);
            }
            $userData = Session::get('userData');
            ///
            $section_02 = Section_02::where('status', 1)->first();
            ///
            $slider_1 = Slider::all();
            $view->with('slider', $slider_1);
            $view->with('section_02_view', $section_02);
            $view->with('userData', $userData);
        });
    }
}
