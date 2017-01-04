<?php

namespace Afonso\Emt;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class RequestLauncherTest extends \PHPUnit_Framework_TestCase
{
    protected $launcher;

    protected $mock;

    protected $stack;

    protected function setUp()
    {
        $this->mock = new MockHandler();
        $this->stack = HandlerStack::create($this->mock);
        $client = new Client(['handler' => $this->stack]);
        $this->launcher = new RequestLauncher('client', 'key', $client);
    }

    public function testLaunchRequestWithSuccessfulResponse()
    {
        $container = [];
        $history = Middleware::history($container);
        $this->stack->push($history);
        $response = new Response(200, [], '{"abc": "def"}');
        $this->mock->append($response);

        $response = $this->launcher->launchRequest('http://foo.com', ['bar' => 'baz']);

        $this->assertEquals('def', $response->abc);
        $this->assertCount(1, $container);
        $this->assertEquals('POST', $container[0]['request']->getMethod());
        $this->assertEquals('http://foo.com', $container[0]['request']->getUri());
        $this->assertEquals('bar=baz&idClient=client&passKey=key', $container[0]['request']->getBody());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Response payload could not be parsed as JSON
     */
    public function testLaunchRequestWithInvalidJsonResponse()
    {
        $container = [];
        $history = Middleware::history($container);
        $this->stack->push($history);
        $response = new Response(200, [], 'this is not valid JSON');
        $this->mock->append($response);

        $response = $this->launcher->launchRequest('http://foo.com');
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Request returned error code '123' ('foo bar baz')
     */
    public function testLaunchRequestWithErrorReturnCode()
    {
        $container = [];
        $history = Middleware::history($container);
        $this->stack->push($history);
        $response = new Response(200, [], '{"ReturnCode": "123", "Description": "foo bar baz"}');
        $this->mock->append($response);

        $response = $this->launcher->launchRequest('http://foo.com');
    }

    public function testCreatingLauncherWithoutAClient()
    {
        $launcher = new RequestLauncher('client', 'key');

        $this->assertInstanceOf(ClientInterface::class, $launcher->getHttpClient());
    }
}
