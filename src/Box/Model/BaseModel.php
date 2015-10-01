<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 5:23 PM
 */

namespace Box\Model;


abstract class BaseModel implements BaseModelInterface
{
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
}