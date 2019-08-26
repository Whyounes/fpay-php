<?php

namespace YouCan\FPay\Api;

interface RequestInterface
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function request(array $params = []);
}
