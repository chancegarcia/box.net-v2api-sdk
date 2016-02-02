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
}