<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use App\Events\WhatsAppMessageReceived;
use App\Listeners\AutoReplyWhatsAppListener;

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
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer([
            'frontend.pages.*',
            'frontend.layouts.*',
            'frontend.blog.*',
            'frontend.ewaste.*',
            'frontend.products.*',
            'frontend.categories.*',
            'frontend.contact.*',
            'frontend.about.*',
            'frontend.partials.*',
        ], function ($view) {
            try {
                $view->with('siteSettings', SiteSetting::getSettings());
            } catch (\Throwable $e) {
                $view->with('siteSettings', null);
            }
        });
        
        // تسجيل PermissionServiceProvider
        $this->app->register(PermissionServiceProvider::class);

        // Register WhatsApp auto-reply listener
        Event::listen(
            WhatsAppMessageReceived::class,
            AutoReplyWhatsAppListener::class
        );
    }
}