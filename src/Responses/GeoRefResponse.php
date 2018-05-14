<?php


namespace Argob\GeoRef\Responses;
use Argob\APIGateway\Responses\APIGatewayResponse;
use GuzzleHttp\Psr7\Response;


class GeoRefResponse extends Response implements APIGatewayResponse
{
    protected $metadata;
    protected $items;
    
    public function __construct(array $items, array $metadata)
    {
        $this->items = $items;
        $this->metadata = $metadata;
    }
    
    public function items(): array
    {
        return $this->items;
    }
    
    public function metadata(): array
    {
        return $this->metadata;
    }
    
}