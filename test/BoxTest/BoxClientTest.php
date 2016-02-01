<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chance
 * Date: 7/23/13
 * Time: 2:19 PM
 *
 * @package     Box
 * @subpackage  BoxTest
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
 *
 *    The MIT License (MIT)
 *
 * Copyright (c) 2013-${YEAR} Chance Garcia
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
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
