<?php


namespace App\Helpers;


use ReflectionClass;
use ReflectionProperty;

class ReflectionUtils {

    /**
     * @param $object
     * @param $className
     * @return array
     * @throws \ReflectionException
     */
    public static function getObjectPrivateFields($object) {

        $result = array();

        $reflect = new ReflectionClass($object);
        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);

        foreach ($props as $property) {
            $property->setAccessible(true);
            $result[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }

        return $result;
    }
}