<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chance
 * Date: 7/23/13
 * Time: 2:19 PM
 * To change this template use File | Settings | File Templates.
 */

namespace BoxTest;
use Box\Model\Client\Client;
use Box\Model\Connection\Token\Token;
use Box\Model\Group\Group;

class BoxClientTest extends \PHPUnit_Framework_TestCase {

    protected $client;

    protected function setUp()
    {
        $client = new Client();
        $token = new Token();
        $token->setAccessToken('DY994XYpCLJ0rErndKZEbYAcS85VsNHB');
        $client->setToken($token);
        $this->setClient($client);
        parent::setUp();
    }

    protected function  setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @param bool $reset
     * @return null|\Box\Model\Client\Client
     */
    protected function getClient($reset=false)
    {
        if (null === $this->client || true === $reset)
        {
            $client = new Client();
            $this->setClient($client);
        }

        return $this->client;
    }

    public function testClient()
    {
        $client = $this->getClient();

        $this->assertInstanceOf('\Box\Model\Client\Client', $client);
    }

    public function testClientToken()
    {
        $client = $this->getClient();
        $token = $client->getToken();

        $this->assertInstanceOf('\Box\Model\Connection\Token\Token', $token);
    }
}
