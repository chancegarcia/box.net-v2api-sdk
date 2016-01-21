<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 5:23 PM
 */

namespace Box\Model;

use Box\Logger\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

abstract class BaseModel implements BaseModelInterface, LoggerAwareInterface
{
    protected $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return BaseModelInterface
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        return $this;
    }

    public function toClassVar($str)
    {
        $aTokens = explode("_", $str);
        $sFirst = array_shift($aTokens);
        $aTokens = array_map('ucfirst', $aTokens);
        array_unshift($aTokens, $sFirst);
        $classVar = implode("", $aTokens);

        return $classVar;
    }

    public function toBoxVar($str)
    {
        $aTokens = preg_split('/(?<=\\w)(?=[A-Z])/', $str);
        $sFirst = array_shift($aTokens);
        $aTokens = array_map('lcfirst', $aTokens);
        array_unshift($aTokens, $sFirst);
        $boxVar = implode("_", $aTokens);

        return $boxVar;
    }

    /**
     * this will bomb out if any properties are private
     * @todo try using setter if found?
     *
     * @param array|StdClass $aData
     *
     * @return $this
     */
    public function mapBoxToClass($aData)
    {
        if ($this->getLogger() instanceof LoggerInterface)
        {
            $this->getLogger()->debug('map data: ' . var_export($aData, true), array(__METHOD__ . ":" . __LINE__));
        }
        // check if value is object or array and map
        // or maybe have a map array of properties/keys that call new classes to map to
        foreach ($aData as $k => $v)
        {
            $sClassProp = $this->toClassVar($k);
            $sSetterMethod = "set" . ucfirst($sClassProp);
            if (method_exists($this, $sSetterMethod))
            {
                $this->{$sSetterMethod}($v);
            }
            else
            {
                $this->{$sClassProp} = $v;
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isInt($number = null)
    {
        if (!is_numeric($number))
        {
            return false;
        }
        else
        {
            if (is_string($number) && false !== strpos($number, "."))
            {
                return false;
            }
            else
            {
                if (!is_int($number) && !is_string($number))
                {
                    return false;
                }
                else
                {
                    if (is_string($number) && !is_int((int)$number))
                    {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEmpty(array $haystack = array())
    {
        foreach ($haystack as $k => $v)
        {
            if (is_array($v))
            {
                $haystack[$k] = $this->removeEmpty($v);
            }

            if (is_string($v))
            {
                $v = trim($v);
            }

            if (empty($v))
            {
                unset($haystack[$k]);
            }
        }

        return $haystack;
    }
}