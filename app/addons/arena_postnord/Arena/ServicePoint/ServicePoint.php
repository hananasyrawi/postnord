<?php

namespace Arena\ServicePoint;

use Arena\Http\HttpRequest;
use Arena\Model\Response;

/***
 * Service Point  
 *
 * @method setCountryCode(string $countryCode)
 * @method setStreetName(string $streetName)
 * @method setPostalCode(string $postalCode)
 * @method setCity(string $city)
 * @method setStreetNumber(string $streetNumber)
 */
class ServicePoint extends HttpRequest
{

    /**
     * Country Code Available in Postnord (SE , FI , DK)
     * by default using SE
     * @var string
     */
    protected $countryCode = 'SE';

    /**
     * How Much ServicePoint Will Be Get When APi Success Called 
     * by default using SE
     * @var string
     */
    protected $numberServicePoint = 12;

    /**
     * Street Name 
     * @var string
     */
    protected $streetName;

    /**
     * Street Number 
     * @var string
     */
    protected $streetNumber;


    /**
     * Postal Code By Country 
     * @var string
     */
    protected $postalCode = "";


    /**
     * Country Code Available in Postnord (SE , FI , DK)
     * by default using SE
     * @param string
     */
    public function setCountryCode($countryCode): ServicePoint
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * Set Postal Code By Country
     * @param string
     */
    public function setPostalCode($postalCode): ServicePoint
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * Set Street Name 
     * @param string
     */
    public function setStreetName($streetName): ServicePoint
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * Set Stree Number 
     * @param string
     */
    public function setStreetNumber($streetNumber): ServicePoint
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     *   Call The Api Postnord To Get Service Point
     *  @return Response
     */
    public function call(): Response
    {

        $url = "{$this->apiUrl}/rest/businesslocation/v5/servicepoints/nearest/byaddress" .
            "?apikey={$this->apiKey}" .
            "&returnType=json" .
            "&countryCode=SE" .
            "&agreementCountry=SE" .
            "&city=Gislaved" .
            "&postalCode={$this->postalCode}" .
            "&streetName={$this->streetName}" .
            "&streetNumber={$this->streetNumber}" .
            "&numberOfServicePoints={$this->numberServicePoint}" .
            "&responseFilter=public" .
            "&typeId=24,25,54";

        return $this->get($url, 'GET');
    }
}
