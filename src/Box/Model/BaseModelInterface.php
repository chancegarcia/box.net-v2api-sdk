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
}