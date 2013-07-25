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

class BoxClientTest extends \PHPUnit_Framework_TestCase {

    protected $client;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function  setClient($client)
    {
        $this->client = $client;
    }

    protected function getClient($reset=false)
    {
        if (null === $this->client || true === $reset)
        {
            $this->setClient(new Client());
        }

        return $this->client;
    }

    public function testClient()
    {
        $this->assertTrue(false);
    }
}
