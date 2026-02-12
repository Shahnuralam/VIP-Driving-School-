<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share navbar and footer pages with all frontend views
        View::composer('frontend.*', function ($view) {
            // Check if table has the new columns
            if (Schema::hasColumn('pages', 'show_in_navbar')) {
                // Get active pages for navbar
                $navbarPages = Page::active()
                    ->inNavbar()
                    ->select('title', 'slug')
                    ->get();
                
                // Get active pages for footer
                $footerPages = Page::active()
                    ->inFooter()
                    ->select('title', 'slug')
                    ->get();
            } else {
                // Fallback if columns don't exist yet
                $navbarPages = collect([]);
                $footerPages = Page::active()
                    ->ordered()
                    ->select('title', 'slug')
                    ->get();
            }
            
            $view->with('navbarPages', $navbarPages);
            $view->with('footerPages', $footerPages);
            
            // Get site settings
            try {
                $settings = Setting::pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                $settings = [];
            }
            $view->with('siteSettings', $settings);
        });
    }
}
