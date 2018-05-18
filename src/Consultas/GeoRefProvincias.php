<?php


namespace Argob\GeoRef\Consultas;
use Argob\APIGateway\Authenticators\APIGatewayAuthenticator;
use Argob\APIGateway\Consultas\APIGatewayConsulta;
use Argob\APIGateway\Responses\APIGatewayResponse;
use Argob\GeoRef\Responses\GeoRefResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use \Illuminate\Support\Facades\Cache;
use Psr\Http\Message\ResponseInterface;

class GeoRefProvincias implements APIGatewayConsulta
{
    protected $authenticator;
    protected $client;
    
    public function __construct(APIGatewayAuthenticator $authenticator, ClientInterface $client)
    {
        $this->authenticator = $authenticator;
        $this->client = $client;
    }
    
    protected function authenticator(): APIGatewayAuthenticator
    {
        return $this->authenticator;
    }
    
    protected function endpoint()
    {
        return env('GEOREF_PROVINCIAS_ENDPOINT');
    }
    
    public function consultar(array $values = []): APIGatewayResponse
    {
        
        try {
            
            $response = $this->client->request('GET', $this->endpoint(), [
        
                'query' => [
                    'orden' => 'nombre',
                ],
    
                'headers'  => [
                    'Authorization' => 'Bearer ' . $this->authenticator()->getToken()->token(),
                ]
    
            ]);
            
            
        } catch (ClientException $exception) {
            
            /**
             * TODO: Loguear mensaje y/o más datos de la exception
             */
            
            $response = $exception->getResponse();
            
        }
        
        return $this->handleResponse($response);
        
    }
    
    protected function handleResponse(ResponseInterface $response): APIGatewayResponse
    {
        $code = $response->getStatusCode();
        
        $results = null;
        
        if ($code == 200) {
    
            $data = json_decode($response->getBody()->getContents());
            
            foreach ($data->results as $result) {
                
                $provincias[$result->id] = $result;
                
            }
            
            $res = new GeoRefResponse(
                
                $provincias,
                [
                    'resultset' => $data->metadata->resultset
                ]
                
            );
            
            Cache::put('georef_data_provincias', $provincias, 3600);
            
        }
        
        
        if ($code == 401) {
        
            $this->authenticator->refreshToken();
        
            $res = $this->consultar();
        
        }
        
        return $res;
    }
    
}