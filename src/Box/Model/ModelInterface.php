<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/17/15
 * Time: 5:36 PM
 */

namespace Box\Model;

interface ModelInterface extends BaseModelInterface
{

    public function __construct(array $options = null);

    /**
     * class properties as an array
     *
     * @return array
     */
    public function classArray();

    /**
     * same as class array except empty elements are filtered out
     * @return array
     */
    public function toBoxArray();

    /**
     * used to throw exceptions that need to contain error information returned from Box
     *
     * @param $data array containing error and error_description keys
     *
     * @throws \Box\Exception\BoxException
     */
    public function error($data);

    /**
     * @param string $class
     * @param  string $classType
     *
     * @throws \Box\Exception\BoxException
     * @return bool returns true if validation passes. Throws exception if unable to validate or validation doesn't pass
     */
    public function validateClass($class, $classType);

    public function buildQuery($params, $numericPrefix = null);

    public function getNewClass($className = null, $classConstructorOptions = null);
}