<?php


namespace Argob\GeoRef\Providers;
use Argob\APIGateway\Authenticators\APIGatewayAuthenticator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
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
        
        $this->app->bind(ClientInterface::class, Client::class);
    
        $this->app->bind('GeoRefProvincias', function ($app) {

            return new GeoRefProvincias(

                $app->make(APIGatewayAuthenticator::class),
                $app->make(ClientInterface::class)

            );
        });
    
        $this->app->bind('GeoRefLocalidades', function ($app) {
        
            return new GeoRefLocalidades(
            
                $app->make(APIGatewayAuthenticator::class),
                $app->make(ClientInterface::class)
        
            );
        })
    
    }
}