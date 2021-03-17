<?php

namespace ALF\LiqPay\ApiClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Class LiqPayApiClient
 */
class LiqPayApiClient
{
    /**
     * @var string
     */
    public const API_URL = 'https://www.liqpay.ua';

    /**
     * @var Client
     */
    public $guzzleClient;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string[]
     */
    private $defaultClientConfiguration = [
        'base_uri' => self::API_URL,
    ];

    /**
     * @var string[]
     */
    private $defaultRequestParams = [
        'version' => 3,
        'public_key' => '',
    ];
    /**
     * @var null|ResponseInterface
     */
    private $lastResponse;

    public function __construct($publicKey, $privateKey, $clientConfig = [])
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->guzzleClient = new Client(array_merge($this->defaultClientConfiguration, $clientConfig));
        $this->defaultRequestParams = array_merge($this->defaultRequestParams, ['public_key' => $publicKey]);
    }

    /**
     * @param $data
     *
     * @return array
     * @throws GuzzleException
     */
    public function request($data): array
    {
        $data = $this->encodeParams(array_merge($this->defaultRequestParams, $data));
        $this->lastResponse = $this->guzzleClient->request('POST', '/api/request', [
            'form_params' => [
                'data' => $data,
                'signature' => $this->generateSign($data)
            ]
        ]);

        return $this->decode($this->lastResponse->getBody());
    }

    /**
     * @return ResponseInterface|null
     */
    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }

    /**
     * @param $str
     *
     * @return array
     */
    private function decode($str): array
    {
        $decoded = json_decode($str, true);

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $decoded;
            case JSON_ERROR_DEPTH:
                throw new RuntimeException('Could not decode JSON, maximum stack depth exceeded.');
            case JSON_ERROR_STATE_MISMATCH:
                throw new RuntimeException('Could not decode JSON, underflow or the nodes mismatch.');
            case JSON_ERROR_CTRL_CHAR:
                throw new RuntimeException('Could not decode JSON, unexpected control character found.');
            case JSON_ERROR_SYNTAX:
                throw new RuntimeException('Could not decode JSON, syntax error - malformed JSON.');
            case JSON_ERROR_UTF8:
                throw new RuntimeException('Could not decode JSON, malformed UTF-8 characters (incorrectly encoded?)');
            default:
                throw new RuntimeException('Could not decode JSON.');
        }
    }

    /**
     * @param string $encodedParams
     *
     * @return string
     */
    private function generateSign(string $encodedParams): string
    {
        return $this->strToSign($this->privateKey . $encodedParams . $this->privateKey);
    }

    /**
     * @param array $params
     * @return string
     */
    private function encodeParams(array $params): string
    {
        return base64_encode(json_encode($params));
    }

    /**
     * @param string $params
     *
     * @return array
     */
    private function decodeParams(string $params): array
    {
        return json_decode(base64_decode($params), true);
    }

    /**
     * @param string $str
     *
     * @return string
     */
    private function strToSign(string $str): string
    {
        return base64_encode(sha1($str, 1));
    }
}
