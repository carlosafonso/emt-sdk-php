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
                ['description' => 'foobar st', 'streetNumber' => 123]
            )
            ->willReturn($this->toObject(['site' => ['foo' => 'bar']]));

        $data = $this->client->getStreet('foobar st', 123);

        $this->assertEquals('bar', $data->site->foo);
    }

    protected function toObject(array $data)
    {
        return json_decode(json_encode($data));
    }
}
