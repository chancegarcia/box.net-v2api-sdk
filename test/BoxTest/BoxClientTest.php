<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chance
 * Date: 7/23/13
 * Time: 2:19 PM
 * To change this template use File | Settings | File Templates.
 */

namespace BoxTest;
use Box\Client\Client;

class BoxClientTest extends \PHPUnit_Framework_TestCase {

    protected $_client;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function  setClient($client)
    {
        $this->_client = $client;
    }

    protected function getClient($reset=false)
    {
        if (null === $this->_client || true === $reset)
        {
            $this->setClient(new Client());
        }

        return $this->_client;
    }

    public function testClient()
    {
        $this->assertTrue(false);
    }
}
