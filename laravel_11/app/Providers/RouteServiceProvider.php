<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Uygulamanın "anasayfa" yolu.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Uygulamanın rota konfigürasyonlarını tanımlamak için boot metodu.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // API rotalarını routes/api.php dosyasından yüklüyoruz
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Web rotalarını routes/web.php dosyasından yüklüyoruz
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Rate limiting yapılandırmasını ayarlıyoruz.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
    }
}