<?php
namespace WebzzMaster\WFirmaSdk\Services;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use WebzzMaster\WFirmaSdk\Components\ConfigParser;

/**
 * Description of BaseService
 *
 * @author jmail <jarek@webzzmaster.com>
 */
abstract class BaseService extends GuzzleClient
{
    /**
     * @var ConfigParser
     */
    protected $config;

    public function __construct(ConfigParser $config)
    {
        $this->config = $config;
    }

    public function __call($name, $arguments)
    {
        throw new Exception("wFirmaSDK: Method " . $name . " of " . get_class($this) . " module does not exist");
    }

    final public function sendRequest(
        string $method,
        string $url,
        array $json = []
    ): array {
        try {
            $response = $this->request(
                $method,
                $this->config->getApiUrl() . $url,
                [
                    'json' => $json,
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'auth' => [
                        $this->config->getUsername(),
                        $this->config->getPassword()
                    ],
                    'query' => [
                        'inputFormat' => 'json',
                        'outputFormat' => 'json'
                    ]
                ]
            );
        } catch (RequestException $e) {
            $context = [
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'request' => Psr7\str($e->getRequest())
            ];

            if ($e->hasResponse()) {
                $context['response'] = Psr7\str($e->getResponse());
            }

            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody(), true);
            }
            throw $e;
        }
        return json_decode($response->getBody(), true);
    }
}
