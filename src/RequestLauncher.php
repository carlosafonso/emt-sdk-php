<?php

namespace Afonso\Emt;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface;
use RuntimeException;

class RequestLauncher
{
    /**
     * The API client ID issued by EMT.
     *
     * @var string
     */
    protected $clientId;

    /**
     * The API passkey issued by EMT.
     *
     * @var string
     */
    protected $passkey;

    /**
     * The Guzzle HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create a new RequestLauncher instance with the provided client ID and
     * passkey.
     *
     * An optional Guzzle HTTP client can be provided as well.
     *
     * @param string $clientId
     * @param string $passkey
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct($clientId, $passkey, ClientInterface $client = null)
    {
        $this->clientId = $clientId;
        $this->passkey = $passkey;

        if ($client === null) {
            $client = new Guzzle();
        }
        $this->client = $client;
    }

    /**
     * Authenticate and execute an arbitrary request.
     *
     * This method adds the relevant authentication parameters to the request
     * and decodes the returned response.
     *
     * @var string $endpoint
     * @var array $params
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function launchRequest($endpoint, $params = [])
    {
        $authParams = ['idClient' => $this->clientId, 'passKey' => $this->passkey];
        $response = $this->client->post(
            $endpoint,
            ['form_params' => array_merge($params, $authParams)]
        );

        $decoded = json_decode((string) $response->getBody());
        if ($decoded === null) {
            throw new RuntimeException('Response payload could not be parsed as JSON');
        }

        if (isset($decoded->ReturnCode)) {
            $returnCode = $decoded->ReturnCode;
            throw new RuntimeException("Request returned error code '{$returnCode}' ('{$decoded->Description}')");
        }

        return $decoded;
    }

    /**
     * Return the HTTP client used by this instance.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public function getHttpClient()
    {
        return $this->client;
    }
}
