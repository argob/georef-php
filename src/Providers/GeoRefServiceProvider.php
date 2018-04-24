<?php


namespace Argob\GeoRef\Providers;
use Argob\APIGateway\Authenticators\JWTAuthenticator;
use Illuminate\Support\ServiceProvider;
use Argob\GeoRef\Consultas\GeoRefProvincias;

class GeoRefServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
        $authenticator = new JWTAuthenticator(
            env('API_GATEWAY_USERNAME', null),
            env('API_GATEWAY_PASSWORD', null),
            env('API_GATEWAY_HOST', null)
        );
    
//        $this->app->singleton('Argob\GeoRef\GeoRefProvincias', function ($app) {
//
//            return new GeoRefProvincias(
//
//                app(JWTAuthenticator::class)
//
//            );
//        });
    
    }
}