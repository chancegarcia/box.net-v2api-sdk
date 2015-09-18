<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/17/15
 * Time: 5:36 PM
 */

namespace Box\Model;


interface ModelInterface
{
    /**
     * class properties as an array
     *
     * @return array
     */
    public function classArray();

    /**
     * used to throw exceptions that need to contain error information returned from Box
     * @param $data array containing error and error_description keys
     * @throws \Box\Exception\Exception
     */
    public function error($data);

    /**
     * @param string $class
     * @param  string $classType
     * @throws \Box\Exception\Exception
     * @return bool returns true if validation passes. Throws exception if unable to validate or validation doesn't pass
     */
    public function validateClass($class,$classType);

    public function buildQuery($params,$numericPrefix=null);

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

    public function getNewClass($className = null, $classConstructorOptions = null);
}