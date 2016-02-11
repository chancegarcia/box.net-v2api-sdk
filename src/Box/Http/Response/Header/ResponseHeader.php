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

namespace Box\Http\Response\Header;

use Box\Exception\BoxException;
use Box\Http\Response\ResponseParser;

class ResponseHeader implements ResponseHeaderInterface
{
    /**
     * @var StatusLineInterface
     */
    protected $statusLine;

    /**
     * @var array
     */
    protected $headerLines = array();

    /**
     * @todo parse groupings based on the header line keys and the groupings (general, response, entity)
     * outlined at https://www.w3.org/Protocols/rfc2616/rfc2616-sec6.html
     */

    /**
     * @param string $sHeader
     * @throws BoxException
     */
    public function __construct($sHeader = '', $statusLineClass = "\\Box\\Http\\Response\\Header\\StatusLine") {
        $aHeader = ResponseParser::parseHeader($sHeader);
        $sStatusLine = array_shift($aHeader);
        if (!is_subclass_of($statusLineClass, "\\Box\\Http\\Response\\Header\\StatusLineInterface")) {
            throw new BoxException("status line class must be an instance of \\Box\\Http\\Response\\Header\\StatusLineInterface. ("
                .$statusLineClass
                .") given.", BoxException::INVALID_CLASS_TYPE);
        }

        /**
         * @var StatusLineInterface $oStatusLine
         */
        $oStatusLine = new $statusLineClass($sStatusLine);

        $this->setStatusLine($oStatusLine);
        $this->setHeaderLines($aHeader);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusLine() {
        return $this->statusLine;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatusLine(StatusLineInterface $statusLine = null) {
        $this->statusLine = $statusLine;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLines() {
        return $this->headerLines;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeaderLines(array $headerLines = null) {
        $this->headerLines = $headerLines;

        return $this;
    }

    public static function parseHeader($sHeaders = '', $replace = true) {
        $finalHeaders = array();
        $aHeaders = explode(PHP_EOL, $sHeaders);;
        foreach ($aHeaders as $headerLineKey => $headerLineValue) {
            // based on protocols found on https://www.w3.org/Protocols/rfc2616/rfc2616-sec6.html
            // first line is Status Line
            if (0 === $headerLineKey) {
                $finalHeaders[] = $headerLineValue;
            } else {
                // rest of the lines are headers
                list($key, $value) = array_map("trim", explode(":", $headerLineValue));
                if (true === $replace || !array_key_exists($key, $finalHeaders)) {
                    $finalHeaders[$key] = $value;
                } else {
                    $finalHeaders[$key] = array_merge((array) $finalHeaders[$key], (array) $value);
                }
            }
        }

        return $finalHeaders;
    }
}