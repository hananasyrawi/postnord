<?php

namespace Arena\Booking;

use Arena\Http\HttpRequest;
use Arena\Model\Response;

class BookingEdiReturn extends HttpRequest
{

    /**
     *  Contain Payload Request 
     * @var int 
     */
    protected string $body;

    /**
     *  Size of QR Code when sending
     * @var int 
     */
    protected int $qrCodeScale = 4;

    /**
     *  Sending Qr into Email  
     * @var bool 
     */
    protected bool $emailQRcode = true;

    /**
     *  Sending Qr into SMS 
     *  @var bool 
     */
    protected bool $smsQRcode = true;

    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function call(): Response
    {

        $url = "{$this->apiUrl}/rest/shipment/v3/returns/edi" .
            "?apikey={$this->apiKey}" .
            "&emailQRcode={$this->emailQRcode}" .
            "&smsQRcode={$this->smsQRcode}" .
            "&qrCodeScale={$this->qrCodeScale}" .
            "&locale=en";

        return $this->post($url, $this->body);
    }
}
