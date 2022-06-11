<?php

namespace Arena\Aditional;

use Arena\Http\HttpRequest;
use Arena\Model\Response;

class BasicServiceCode extends HttpRequest
{
    /**
     * @var string body 
     */
    protected string $body;
  
    /**
     * @var string body 
     * @inheritdoc
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function call(): Response
    {
        $url = "{$this->apiUrl}/rest/shipment/v3/edi/servicecodes/adnlservicecodes/combinations?apikey={$this->apiKey}";
        return $this->get($url, 'GET');
    }
}
