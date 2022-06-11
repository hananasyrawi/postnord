<?php

namespace Arena\Booking;

use Arena\Http\HttpRequest;
use Arena\Model\Response;

class PickupPostnord extends HttpRequest
{

    protected string $body;

    /**
     * Set body
     * @inheritdoc
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * Call Api 
     * @inheritdoc
     */
    public function call(): Response
    {
        return $this->post('some', 'some');
    }
}
