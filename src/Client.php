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
     * The request launcher instance.
     *
     * @var \Afonso\Emt\RequestLauncher
     */
    protected $launcher;

    /**
     * Create a new Client instance with the given client ID and passkey.
     *
     * @param string $clientId
     * @param string $passkey
     */
    public function __construct($clientId, $passkey)
    {
        $this->launcher = new RequestLauncher($clientId, $passkey);
    }

    /**
     * Return the itinerary of one or more lines.
     *
     * @var int[] $lines
     * @var \DateTime $date
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getRouteLines(array $lines, DateTime $date)
    {
        $params = [
            'Lines' => join('|', $lines),
            'SelectDate' => $date->format('d/m/Y'),
        ];
        return $this->callBusService('GetRouteLines.php', $params);
    }

    /**
     * Return calendar details for the given date interval.
     *
     * @var \DateTime $startDate
     * @var \DateTime $endDate
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getCalendar(DateTime $startDate, DateTime $endDate)
    {
        $params = [
            'SelectDateBegin' => $startDate->format('d/m/Y'),
            'SelectDateEnd' => $endDate->format('d/m/Y'),
        ];
        return $this->callBusService('GetCalendar.php', $params);
    }

    /**
     * Return a list with line details.
     *
     * @var int[] $lines
     * @var \DateTime $date
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getListLines(array $lines, DateTime $date)
    {
        $params = [
            'Lines' => join('|', $lines),
            'SelectDate' => $date->format('d/m/Y'),
        ];
        return $this->callBusService('GetListLines.php', $params);
    }

    /**
     * Return details about all line groups.
     *
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getGroups()
    {
        return $this->callBusService('GetGroups.php');
    }

    /**
     * Return start and end operation times of one or more lines.
     *
     * @var int[] $lines
     * @var \DateTime $date
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getTimesLines(array $lines, DateTime $date)
    {
        $params = [
            'Lines' => join('|', $lines),
            'SelectDate' => $date->format('d/m/Y'),
        ];
        return $this->callBusService('GetTimesLines.php', $params);
    }

    /**
     * Return timetable details of one or more lines.
     *
     * @var int[] $lines
     * @var \DateTime $date
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getTimeTableLines(array $lines, DateTime $date)
    {
        $params = [
            'Lines' => join('|', $lines),
            'SelectDate' => $date->format('d/m/Y'),
        ];
        return $this->callBusService('GetTimeTableLines.php', $params);
    }

    /**
     * Return details of one or more bus stops including name, served lines
     * and geographic coordinates.
     *
     * @var int[] $stopIds
     * @return \stdClass
     * @throws \RuntimeException
     */
    public function getNodesLines(array $stopIds)
    {
        $params = [
            'Nodes' => join('|', $stopIds),
        ];
        return $this->callBusService('GetNodesLines.php', $params);
    }

    /**
     * Set the RequestLauncher instance to be used by this client.
     *
     * @param \Afonso\Emt\RequestLauncher $launcher
     */
    public function setRequestLauncher(RequestLauncher $launcher)
    {
        $this->launcher = $launcher;
    }

    /**
     * Make an arbitrary call to the Bus service.
     *
     * @param string $endpoint
     * @param array $params
     * @return \stdClass
     */
    protected function callBusService($endpoint, array $params = [])
    {
        $url = self::ENDPOINT . '/emt-proxy-server/last/bus/' . $endpoint;
        return $this->launcher->launchRequest($url, $params)->resultValues;
    }
}
