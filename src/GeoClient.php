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
     * Return details about stops around a given address and, optionally,
     * within the specified radius.
     *
     * An optional radius can be passed as well.
     *
     * @param string $streetName
     * @param int $streetNumber
     * @param int|null $radius
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getStreet($streetName, $streetNumber, $radius = null)
    {
        $params = [
            'description' => $streetName,
            'streetNumber' => $streetNumber,
            'Radius' => $radius,
        ];
        return $this->callGeoService('GetStreet.php', $params);
    }

    /**
     * Return details about stops around a given stop and, optionally, within
     * the specified radius.
     *
     * @param int $stopId
     * @param int|null $radius
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getStopsFromStop($stopId, $radius = null)
    {
        $params = [
            'idStop' => $stopId,
            'Radius' => $radius,
        ];
        return $this->callGeoService('GetStopsFromStop.php', $params);
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
