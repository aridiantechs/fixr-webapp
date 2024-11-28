<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        view()->composer('*', function ($view) 
        {
            $view->with([
                'align'  => session('locale') == 'ar' ? 'right' : 'left',
                'align3letter'  => session('locale') == 'ar' ? 'rtl' : 'ltr',
                'reverseAlign3Letter' => session('locale') == 'ar' ? 'ltr' : 'rtl',
                'alignShort'    => session('locale') == 'ar' ? 'l' : 'r',
                'alignShortRev' => session('locale') == 'ar' ? 'r' : 'l',
                'textAlign'     => session('locale') == 'ar' ? 'text-right' : '',
                'btnAlign'      => session('locale') == 'ar' ? 'btn-rtl' : 'btn-ltr',
                'alignreverse'  => session('locale') == 'ar' ? 'left' : 'right',
            ] );    
        });
        
    }
}
