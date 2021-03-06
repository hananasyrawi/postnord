<?php


namespace Arena\Model;


class Response
{

    protected $status;

    protected $body;

    protected $info;

    /**
     * Construct a Billy Request with an API key and an API version.
     *
     * @param array $info Info about the response
     * @param array $body Body of the response
     */
    public function __construct($info, $body)
    {
        $this->info = $info;
        $this->body = $body;
    }

    /**
     * Get the response body
     *
     * @return object stdClass
     */
    public function getBody()
    {
        return $this->interpretResponse($this->body);
    }

    public function getInfo()
    {
      return $this->info;
    }

    /**
     * Get the status code
     *
     * @return object stdClass
     */
    public function isSuccess()
    {
        return ($this->info['http_code'] === 200);
    }

    /**
     * Takes a raw JSON response and decodes it. If an error is met,
     * throw an exception. Else return array.
     *
     * @param string $rawResponse JSON encoded array
     *
     * @return array Response from PostNord API, e.g. id and success
     * or invoice object
     * @throws PostNord_Exception Error, Help URL and response
     */
    protected function interpretResponse($rawResponse)
    {
        $response = json_decode($rawResponse);
        return $response;
    }
}
