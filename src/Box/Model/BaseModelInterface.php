<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 5:25 PM
 */

namespace Box\Model;

interface BaseModelInterface
{
    /**
     * @param $str
     *
     * @return mixed
     */
    public function toClassVar($str);

    public function toBoxVar($str);

    /**
     * this will bomb out if any properties are private
     * @todo try using setter if found?
     *
     * @param $aData
     *
     * @return $this
     */
    public function mapBoxToClass($aData);

    /**
     * validate integer value even if it is a string value, unlike is_int()
     *
     * @param mixed $number
     *
     * @return bool
     */
    public function isInt($number = null);
}