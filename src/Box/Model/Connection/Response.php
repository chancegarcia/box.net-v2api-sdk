<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
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
