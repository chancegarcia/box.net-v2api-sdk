<?php
/**
 * @package     Box
 * @subpackage  Box_Http_Response
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2016 Chance Garcia, chancegarcia.com
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 */

namespace Box\Http\Response;

use Box\Http\Response\Header\ResponseHeaderInterface;
use Zend\Stdlib\ResponseInterface;

interface BoxResponseInterface
{
    /**
     * @return ResponseHeaderInterface
     */
    public function getResponseHeader();

    /**
     * @param ResponseHeaderInterface $header
     * @return BoxResponseInterface
     */
    public function setResponseHeader(ResponseHeaderInterface $header = null);

    /**
     * @return mixed
     */
    public function getContent();

    public function hasHeader($name);

    public function getHeader($name);

    public function getHeaderLine($name);

    // making interface entries for httpfoundation Response class that we extend and use

    /**
     * Retrieves the status code for the current web response.
     *
     * @return int Status code
     */
    public function getStatusCode();

    /**
     * Sets the HTTP protocol version (1.0 or 1.1).
     *
     * @param string $version The HTTP protocol version
     *
     * @return ResponseInterface
     */
    public function setProtocolVersion(string $version);

    // http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
    /**
     * Is response invalid?
     *
     * @return bool
     */
    public function isInvalid();

    /**
     * Is response informative?
     *
     * @return bool
     */
    public function isInformational();

    /**
     * Is response successful?
     *
     * @return bool
     */
    public function isSuccessful();

    /**
     * Is the response a redirect?
     *
     * @return bool
     */
    public function isRedirection();

    /**
     * Is there a client error?
     *
     * @return bool
     */

    public function isClientError();

    /**
     * Was there a server side error?
     *
     * @return bool
     */
    public function isServerError();

    /**
     * Is the response OK?
     *
     * @return bool
     */
    public function isOk();

    /**
     * Is the response forbidden?
     *
     * @return bool
     */
    public function isForbidden();

    /**
     * Is the response a not found error?
     *
     * @return bool
     */
    public function isNotFound();

    /**
     * Is the response empty?
     *
     * @return bool
     */
    public function isEmpty();
}