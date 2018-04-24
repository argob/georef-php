<?php


namespace Argob\GeoRef\Consultas;
use Argob\APIGateway\Authenticators\APIGatewayAuthenticator;
use Argob\APIGateway\Consultas\APIGatewayConsulta;
use Argob\APIGateway\Responses\APIGatewayResponse;
use Argob\GeoRef\Responses\GeoRefResponse;
use \GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use \Illuminate\Support\Facades\Cache;

class GeoRefLocalidades implements APIGatewayConsulta
{
    
    public function __construct(APIGatewayAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }
    
    protected function authenticator()
    {
        return $this->authenticator;
    }
    
    protected function endpoint()
    {
        return env('GEOREF_LOCALIDADES_ENDPOINT');
    }
    
    public function consultar(): APIGatewayResponse
    {
        
        try {
    
            $client = new Client([
                'timeout'  => 2.0,
            ]);
    
            $res = $client->request('GET', $this->endpoint(), [
        
                'query' => [
                    'orden' => 'nombre',
                ],
    
                'headers'  => [
                    'Authorization' => 'Bearer ' . $this->authenticator->getToken()->token(),
                ]
    
            ]);
            
            $response = $this->handleResponse($res);
            
        } catch (ClientException $request) {
            
            $response = $this->handleError($request);
            
        }
        
        return $response;
        
    }
    
    protected function handleResponse($response)
    {
        $code = $response->getStatusCode();
        
        $results = null;
        
        if ($code == 200) {
    
            $data = json_decode($response->getBody()->getContents());
            
            $res = new GeoRefResponse();
            
            $res->setMetadata(
                
                [
                    'resultset' => $data->metadata->resultset
                ]
            );
            
            $res->setItems($data->results);
            
            Cache::put('georef_data_localidades', $res);
            
        }
    
        return $res;
    }
    
    protected function handleError(ClientException $error)
    {
       
        $code = $error->getCode();
        
        if($code == 401) {
            
            $this->authenticator->refreshToken();
            
            $this->consultar();
            
        }
    }
    
}