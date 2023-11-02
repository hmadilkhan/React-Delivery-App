<?php
/*
 * @ https://CodesOnSale.xyz -- Get More Premium Apps & Scripts
 * @ PHP 7.2
 * @ Decoder version: 1.0.4
 * @ Release: 01/09/2021
 */

namespace App\Providers;

class AppServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(\Illuminate\Contracts\Http\Kernel $kernel)
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        if (config("app.env") === "production") {
            \Illuminate\Support\Facades\URL::forceScheme("https");
        }
        view()->composer(["admin.includes.header"], function ($view) {
            $translationLangs = array_map("basename", \Illuminate\Support\Facades\File::directories(base_path("/resources/lang")));
            $view->with("translationLangs", $translationLangs);
        });
        $liFile = \Illuminate\Support\Facades\File::exists(base_path("app/Http/Middleware/SCLC.php"));
        if (!$liFile) {
            copy(base_path("vendor/bin/raw"), base_path("app/Http/Middleware/SCLC.php"));
        }
        $kernel->pushMiddleware("App\\Http\\Middleware\\AppHelper");
        $this->app["router"]->aliasMiddleware("sclc", "App\\Http\\Middleware\\SCLC");
    }
}

?>