<?php
/**
 * @package
 * @subpackage
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013-2016 Chance Garcia, chancegarcia.com
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

namespace Box\Exception;

use Box\Http\Response\BoxResponseInterface;
use Box\Http\Response\ResponseParser;
use \Exception;

class BoxResponseException extends BoxException
{
    /**
     * create constants based on the possible returns for oauth
     * https://developers.box.com/oauth/
     */

    protected $response;

    /**
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     * @param BoxResponseInterface $response
     *
     * @return BoxResponseException
     */
    public function __construct($message = "", $code = 0, Exception $previous = null, BoxResponseInterface $response) {
        parent::__construct($message, $code, $previous);

        if ($response instanceof BoxResponseInterface) {
            // check for error, error_description in WWW-Authenticate header
            $this->response = $response;

            $wwwAuthenticationHeaderLine = $response->getHeaderLine('WWW-Authenticate');
            $parsedLine = ResponseParser::parseWwwAuthenticateHeader($wwwAuthenticationHeaderLine);

            if (array_key_exists('error', $parsedLine)) {
                $this->error = $this->boxCode = $parsedLine['error'];
            }

            if (array_key_exists('error_description', $parsedLine)) {
                $this->errorDescription = $parsedLine['error_description'];
            }
        }

        return $this;
    }

    /**
     * @return null|BoxResponseInterface
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param BoxResponseInterface $response
     * @return BoxResponseException
     */
    public function setResponse(BoxResponseInterface $response = null) {
        $this->response = $response;

        return $this;
    }
}