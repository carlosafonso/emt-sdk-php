<?php

namespace Afonso\Emt;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The Client instance under test.
     *
     * @var \Afonso\Emt\Client
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->launcherMock = $this->createMock(RequestLauncher::class);
        $this->client = new Client('client', 'passkey');
        $this->client->setRequestLauncher($this->launcherMock);
    }

    public function testGetRouteLines()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetRouteLines.php',
                ['Lines' => '123|456', 'SelectDate' => '04/01/2017']
            )
            ->willReturn($this->toObject(['resultValues' => [['foo' => 'bar']]]));

        $data = $this->client->getRouteLines([123, 456], new \DateTime('2017-01-04'));

        $this->assertCount(1, $data);
        $this->assertEquals('bar', $data[0]->foo);
    }

    public function testGetCalendar()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetCalendar.php',
                ['SelectDateBegin' => '01/01/2017', 'SelectDateEnd' => '04/01/2017']
            )
            ->willReturn($this->toObject(['resultValues' => [['foo' => 'bar']]]));

        $data = $this->client->getCalendar(new \DateTime('2017-01-01'), new \DateTime('2017-01-04'));

        $this->assertCount(1, $data);
        $this->assertEquals('bar', $data[0]->foo);
    }

    public function testGetListLines()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetListLines.php',
                ['Lines' => '999', 'SelectDate' => '04/01/2017']
            )
            ->willReturn($this->toObject(['resultValues' => [['foo' => 'bar']]]));

        $data = $this->client->getListLines([999], new \DateTime('2017-01-04'));

        $this->assertCount(1, $data);
        $this->assertEquals('bar', $data[0]->foo);
    }

    public function testGetGroups()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with('https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetGroups.php')
            ->willReturn($this->toObject(['resultValues' => [['foo' => 'bar']]]));

        $data = $this->client->getGroups();

        $this->assertCount(1, $data);
        $this->assertEquals('bar', $data[0]->foo);
    }

    public function testGetTimesLines()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetTimesLines.php',
                ['Lines' => '456|789', 'SelectDate' => '04/01/2017']
            )
            ->willReturn($this->toObject(['resultValues' => [['foo' => 'bar']]]));

        $data = $this->client->getTimesLines([456, 789], new \DateTime('2017-01-04'));

        $this->assertCount(1, $data);
        $this->assertEquals('bar', $data[0]->foo);
    }

    public function testGetTimeTableLines()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetTimeTableLines.php',
                ['Lines' => '123|234', 'SelectDate' => '04/01/2017']
            )
            ->willReturn($this->toObject(['resultValues' => [['foo' => 'bar']]]));

        $data = $this->client->getTimeTableLines([123, 234], new \DateTime('2017-01-04'));

        $this->assertCount(1, $data);
        $this->assertEquals('bar', $data[0]->foo);
    }

    public function testGetNodesLines()
    {
        $this->launcherMock->expects($this->once())
            ->method('launchRequest')
            ->with(
                'https://openbus.emtmadrid.es:9443/emt-proxy-server/last/bus/GetNodesLines.php',
                ['Nodes' => '1234|5678|9012']
            )
            ->willReturn($this->toObject(['resultValues' => [['foo' => 'bar']]]));

        $data = $this->client->getNodesLines([1234, 5678, 9012]);

        $this->assertCount(1, $data);
        $this->assertEquals('bar', $data[0]->foo);
    }

    protected function toObject(array $data)
    {
        return json_decode(json_encode($data));
    }
}
