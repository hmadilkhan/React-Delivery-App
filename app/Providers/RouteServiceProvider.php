<?php
/*
 * @ https://CodesOnSale.xyz -- Get More Premium Apps & Scripts
 * @ PHP 7.2
 * @ Decoder version: 1.0.4
 * @ Release: 01/09/2021
 */

namespace App\Providers;

class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    protected $namespace = "App\\Http\\Controllers";
    public function boot()
    {
        parent::boot();
    }
    public function map()
    {
        $this->mapApiRoutes();
    }
    protected function mapApiRoutes()
    {
        \Illuminate\Support\Facades\Route::prefix("api")->middleware("api")->namespace($this->namespace)->group(base_path("routes/api.php"));
    }
}

?>