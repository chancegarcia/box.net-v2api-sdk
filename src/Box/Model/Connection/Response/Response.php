<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
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

namespace Box\Model\Connection\Response;

use Box\Model\Model;
use Box\Model\Connection\Response\ResponseInterface;

class Response extends Model implements ResponseInterface
{
    protected $responseType;
    protected $accessToken;
    protected $expiresIn;
    protected $tokenType;
    protected $refreshToken;
    protected $error;
    protected $errorDescription;

}
