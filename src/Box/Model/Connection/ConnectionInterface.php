<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
 *
 *    The MIT License (MIT)
 *
 * Copyright (c) 2013-2016 Chance Garcia
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

namespace Box\Model\Connection;

use Box\Exception\BoxException;
use Box\Http\Response\BoxResponseInterface;
use Box\Model\ModelInterface;
use CURLFile;

interface ConnectionInterface extends ModelInterface
{
    public function connect();

    /**
     * GET
     * @param string $uri
     * @return BoxResponseInterface
     */
    public function query($uri);

    /**
     * POST
     *
     * @param              $uri
     * @param array|string $params will convert array to string; array will be deprecated in the future; json
     *                                  encoded string will become the only valid value
     * @param bool|false $nameValuePair this will be deprecated/fully removed in the future since params as a json
     *                                  encoded string will be the expected value
     *
     * @return BoxResponseInterface
     */
    public function post($uri, $params = array(), $nameValuePair = false);

    /**
     * @param resource $ch
     * @return resource
     * @throws BoxException
     */
    public function initAdditionalCurlOpts($ch);

    /**
     * @param array $curlOpts
     * @return ConnectionInterface
     */
    public function setCurlOpts($curlOpts = null);

    /**
     * @return array
     */
    public function getCurlOpts();

    /**
     * @return resource
     */
    public function initCurl();

    /**
     * @param resource $ch
     * @return resource
     */
    public function initCurlOpts($ch);

    /**
     * @param resource $ch
     * @return BoxResponseInterface
     */
    public function getCurlData($ch);

    /**
     * @param $uri
     * @param array|string $params array will be deprecated in the future; json encoded string will become the only valid value
     * @param bool|false $nameValuePair this will be deprecated/fully removed in the future since params as a json encoded
     *                                  string will be the expected value
     *
     * @return BoxResponseInterface
     */
    public function put($uri, $params = array());

    /**
     * @param string $pathToFile
     * @param string $mimeType
     * @param string $filename name of the file/post name
     * @return CURLFile
     */
    public function createCurlFile($pathToFile, $mimeType, $filename);

    /**
     * @param string $file file/path to file
     * @return mixed
     */
    public function getMimeType($file);

    /**
     * @param string $uri
     * @param string $file file/path to file
     * @param int $parentId
     * @return array|BoxResponseInterface
     */
    public function postFile($uri, $file, $parentId = 0);
}
