<?php

namespace Arena\Aditional;

use Arena\Http\HttpRequest;
use Arena\Model\Response;

class BasicServiceCode extends HttpRequest
{

    public function call(): Response
    {
        $url = "{$this->apiUrl}/rest/shipment/v3/edi/servicecodes/adnlservicecodes/combinations?apikey={$this->apiKey}";
        return $this->get($url, 'GET');
    }
}
