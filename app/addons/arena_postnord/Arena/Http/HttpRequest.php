<?php

/**
 * @author   Hanan Asyrawi 
 * @email    hanan@arenasoftwares.com
 */

namespace Arena\Http;

use Arena\Model\Response;
use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');


define('API_URL', Registry::get('addons.arena_postnord.postnord_URL'));


trait UseHttpRequest
{
    public function get(string $url, $method = 'GET'): Response
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        $res = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        $response = new Response($info, $res);

        return $response;
    }

    public function post(string $url, string $body): Response
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        $res = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        $response = new Response($info, $res);

        return $response;
    }
}


abstract class HttpRequest
{

    use UseHttpRequest;

    /**
     * Api Key From Postnord 
     * @var string
     */
    protected $apiKey;


    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     *   by default will be using sandbox API URL
     * @var string
     */
    protected $apiUrl = API_URL;


    abstract public function call(): Response;

    abstract public function setBody(string $body);

}
