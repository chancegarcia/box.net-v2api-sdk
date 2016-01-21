<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 1/20/16
 * Time: 9:14 PM
 */

namespace Box\Logger;

use Psr\Log\LoggerInterface;

interface LoggerAwareInterface extends \Psr\Log\LoggerAwareInterface
{
    /**
     * @return LoggerInterface
     */
    public function getLogger();
}