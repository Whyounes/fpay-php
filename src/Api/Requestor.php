<?php

namespace YouCan\FPay\Api;

use GuzzleHttp\Client;

/**
 * Class Requestor
 * @package YouCan\FPay\Api
 */
class Requestor
{
    /** @var \GuzzleHttp\Client */
    protected $guzzle;

    protected $configs;

    public function __construct(string $clientId, string $merchantKey, string $merchantCode)
    {
        $this->guzzle = new Client([
            'base_uri' => $this->getBaseUri(),
        ]);

        $this->configs = [
            'client_id'     => $clientId,
            'merchant_key'  => $merchantKey,
            'merchant_code' => $merchantCode,
        ];
    }

    protected function getBaseUri()
    {
        if (env('APP_ENV') !== 'production') {
            return 'https://pay.fpay-worldwide.com/sandbox/';
        }

        throw new \LogicException('Plz define a base URI to FPay for production');
    }

    /**
     * @param string $uri
     * @param array $options
     * @param string $method
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function call(string $uri, array $options, string $method = 'POST')
    {
        $response = $this->guzzle->request(
            $method,
            $this->getBaseUri() . $uri,
            $options + $this->configs
        );

        $responsePayload = (string)$response->getBody();

        return $responsePayload;
    }
}
