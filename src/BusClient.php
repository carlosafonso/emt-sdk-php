<?php

namespace Afonso\Emt;

use DateTime;
use RuntimeException;

/**
 * The SDK client for the EMT OpenData API BUS service.
 *
 * @author Carlos Afonso Pérez <carlos.afonso.perez@gmail.com>
 */
class BusClient extends Client
{
    /**
     * Return the itinerary of one or more lines.
     *
     * @param int[] $lines
     * @param \DateTime $date
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
     * @param \DateTime $startDate
     * @param \DateTime $endDate
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
     * @param int[] $lines
     * @param \DateTime $date
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
     * @param int[] $lines
     * @param \DateTime $date
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
     * @param int[] $lines
     * @param \DateTime $date
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
     * @param int[] $stopIds
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
     * Make an arbitrary call to the BUS service.
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
