<?php

namespace YouCan\FPay\Api;

use Illuminate\Support\Collection;

/**
 * Class Tokenize
 * @package YouCan\FPay\Api
 */
class Tokenize implements RequestInterface
{
    const ENDPOINT = 'tokenizer/rest/token/tokenize';

    /** @var \YouCan\FPay\Api\Requestor */
    protected $requestor;

    public function __construct(Requestor $requestor)
    {
        $this->requestor = $requestor;
    }

    /**
     * @param array $params
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(array $params = [])
    {
        $params = $this->validateParams($params);

        return $this->requestor->call(self::ENDPOINT, $params);
    }

    /**
     * @param array $params
     *
     * @throws \InvalidArgumentException When a required param is missing.
     *
     * @return array
     */
    private function validateParams(array $params): array
    {
        $params = new Collection($params);

        $optionalParams = [
            'firstName',
            'lastName',
            'address',
            'city',
            'zipCode',
            'phone',
            'userAgent',
            'customData',
        ];

        $requiredParams = new Collection([
            'email',
            'ipAddress',
            'keepAlive',
        ]);

        $requiredParams->each(function ($param) use ($params) {
            throw_if(
                !$params->has($param),
                new \InvalidArgumentException("Required param `$param` is missing.")
            );
        });

        return $params->only($optionalParams + $requiredParams)->toArray();
    }
}
