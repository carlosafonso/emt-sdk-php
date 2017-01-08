<?php

namespace Afonso\Emt;

class GeoClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The Client instance under test.
     *
     * @var \Afonso\Emt\BusClient
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->launcherMock = $this->createMock(RequestLauncher::class);
        $this->client = new GeoClient('client', 'passkey');
        $this->client->setRequestLauncher($this->launcherMock);
    }

    public function testGetStreet()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetStreet.php',
                ['description' => 'foobar st', 'streetNumber' => 123, 'Radius' => 500]
            )
            ->willReturn($this->toObject(['site' => ['foo' => 'bar']]));

        $data = $this->client->getStreet('foobar st', 123, 500);

        $this->assertEquals('bar', $data->site->foo);
    }

    public function testGetStopsFromStop()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetStopsFromStop.php',
                ['idStop' => 1234, 'Radius' => 500]
            )
            ->willReturn($this->toObject(['stops' => [['foo' => 'bar']]]));

        $data = $this->client->getStopsFromStop(1234, 500);

        $this->assertEquals('bar', $data->stops[0]->foo);
    }

    public function testGetStopsFromXY()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/geo/GetStopsFromXY.php',
                ['coordinateX' => 10.5, 'coordinateY' => -6.8, 'Radius' => 500]
            )
            ->willReturn($this->toObject(['stops' => [['foo' => 'bar']]]));

        $data = $this->client->getStopsFromXY(10.5, -6.8, 500);

        $this->assertEquals('bar', $data->stops[0]->foo);
    }

    protected function toObject(array $data)
    {
        return json_decode(json_encode($data));
    }
}
