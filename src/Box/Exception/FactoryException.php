<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/30/15
 * Time: 10:47 AM
 */

namespace Box\Exception;

class FactoryException extends BoxException
{
    const CLASS_DOES_NOT_EXIST = 1;
    const CAN_NOT_INSTANTIATE_WITH_OPTIONS = 2;
}