<?php

namespace Arena\Booking;

use Arena\Http\HttpRequest;
use Arena\Model\Response;

class BookingEdi extends HttpRequest
{


    /**
     * Call API 
     */
    public function call(): Response
    {
        return $this->post('/booking/edi', "some");
    }
}
