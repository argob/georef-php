<?php


namespace Argob\GeoRef\Providers;
use Argob\APIGateway\Authenticators\APIGatewayAuthenticator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use Argob\GeoRef\Consultas\GeoRefProvinciasService;
use Argob\GeoRef\Consultas\GeoRefLocalidadesService;

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
    
        $this->app->bind('GeoRefProvinciasService', function ($app) {

            return new GeoRefProvinciasService(

                $app->make(APIGatewayAuthenticator::class),
                $app->make(ClientInterface::class)

            );
        });
    
        $this->app->bind('GeoRefLocalidadesService', function ($app) {
        
            return new GeoRefLocalidadesService(
            
                $app->make(APIGatewayAuthenticator::class),
                $app->make(ClientInterface::class)
        
            );
        });
    
    }
}