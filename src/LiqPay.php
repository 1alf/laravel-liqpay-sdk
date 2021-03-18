<?php

namespace ALF\LiqPay;

use ALF\LiqPay\ApiClient\LiqPayApiClient;

/**
 * Class LiqPay
 */
class LiqPay
{
    /**
     * @var LiqPayApiClient
     */
    private $apiClient;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * LiqPay constructor.
     *
     * @param string $publicKey
     * @param string $privateKey
     */
    public function __construct(string $publicKey = '', string $privateKey = '')
    {
        $this->publicKey = $publicKey ?: config('liqpay.public_key');
        $this->privateKey = $privateKey ?: config('liqpay.private_key');
    }

    /**
     * @param array $clientConfig
     *
     * @return LiqPayApiClient
     */
    public function getApiClient(array $clientConfig = []): LiqPayApiClient
    {
        if (null === $this->apiClient || !empty($clientConfig)) {
            $this->apiClient = $this->initApiClient($clientConfig);
        }

        return $this->apiClient;
    }

    /**
     * @param array $clientConfig
     *
     * @return LiqPayApiClient
     */
    private function initApiClient(array $clientConfig = []): LiqPayApiClient
    {
        return new LiqPayApiClient($this->publicKey, $this->privateKey, $clientConfig);
    }
}
