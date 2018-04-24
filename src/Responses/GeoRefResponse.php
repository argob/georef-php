<?php


namespace Argob\GeoRef\Responses;
use Argob\APIGateway\Responses\APIGatewayResponse;


class GeoRefResponse implements APIGatewayResponse
{
    protected $metadata;
    protected $items;
    
    public function items()
    {
        return $this->items;
    }
    
    public function metadata()
    {
        return $this->metadata;
    }
    
    public function setItems(array $items)
    {
        $this->items = $items;
    }
    
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }
    
}