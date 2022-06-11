<?php

namespace Arena\Booking;

use Arena\Http\HttpRequest;
use Arena\Model\Response;

class BookingEdi extends HttpRequest
{
    /**
     * @var string body 
     */
    protected string $body;


    /**
     * @var string body 
     * @inheritdoc
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * Call API 
     */
    public function call(): Response
    {

        $url = "{$this->apiUrl}/rest/shipment/v3/edi/labels/pdf?apikey={$this->apiKey}" .
            "&paperSize=A4" .
            "&rotate=0" .
            "&multiPDF=false" .
            "&labelType=standard" .
            "&pnInfoText=false" .
            "&labelsPerPage=100" .
            "&page=1" .
            "&processOffline=false" .
            "&storeLabel=false";

        // Implement Booking EDI with label PDF in here
        return $this->post($url, $this->body);
    }
}
