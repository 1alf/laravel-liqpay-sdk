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

    public function __construct(string $publicKey, string $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
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
