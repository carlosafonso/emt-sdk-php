<?php

namespace Afonso\Emt;

use RuntimeException;

/**
 * The SDK client for the EMT OpenData API GEO service.
 *
 * @author Carlos Afonso Pérez <carlos.afonso.perez@gmail.com>
 */
class GeoClient extends Client
{
    /**
     * Return stops around a given address as well as lines that serve those
     * stops.
     *
     * @var string $streetName
     * @var int $streetNumber
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getStreet($streetName, $streetNumber)
    {
        $params = [
            'description' => $streetName,
            'streetNumber' => $streetNumber,
        ];
        return $this->callGeoService('GetStreet.php', $params);
    }

    /**
     * Make an arbitrary call to the GEO service.
     *
     * @param string $endpoint
     * @param array $params
     * @return \stdClass
     */
    protected function callGeoService($endpoint, array $params = [])
    {
        $url = self::ENDPOINT . '/emt-proxy-server/last/geo/' . $endpoint;
        return $this->launcher->launchRequest($url, $params);
    }
}
