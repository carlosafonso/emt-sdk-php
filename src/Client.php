<?php

namespace Afonso\Emt;

use DateTime;
use GuzzleHttp\Client as Guzzle;
use RuntimeException;

/**
 * The SDK client for the EMT OpenData API.
 *
 * @author Carlos Afonso Pérez <carlos.afonso.perez@gmail.com>
 */
class Client
{
    const ENDPOINT = 'https://openbus.emtmadrid.es:9443';

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
     * Create a new Client instance with the given client ID and passkey.
     *
     * @param string $clientId
     * @param string $passkey
     */
    public function __construct($clientId, $passkey)
    {
        $this->clientId = $clientId;
        $this->passkey = $passkey;
        $this->client = new Guzzle(['base_uri' => self::ENDPOINT]);
    }

    /**
     * Return the itinerary of one or more lines.
     *
     * @var int[] $lines
     * @var \DateTime $date
     * @return \stdClass
     */
    public function getRouteLines(array $lines, DateTime $date)
    {
        $params = [
            'Lines' => join('|', $lines),
            'SelectDate' => $date->format('d/m/Y'),
        ];
        return $this->doRequest('/emt-proxy-server/last/bus/GetRouteLines.php', $params)->resultValues;
    }

    /**
     * Authenticate and execute an arbitrary request to the EMT API.
     *
     * This method adds the relevant authentication parameters to the request
     * and decodes the returned response.
     *
     * @var string $endpoint
     * @var string $params
     * @return \stdClass
     * @throws \RuntimeException
     */
    protected function doRequest($endpoint, $params)
    {
        $authParams = ['idClient' => $this->clientId, 'passKey' => $this->passkey];
        $response = $this->client->post(
            $endpoint,
            ['form_params' => array_merge($params, $authParams)]
        );

        if ($status = $response->getStatusCode() !== 200) {
            throw new RuntimeException("Request returned non-200 HTTP status code ($status)");
        }

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
}
