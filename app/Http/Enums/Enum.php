<?php

namespace App\Http\Enums;

/**
 * Class Enum
 * @package App\Http\Enums
 */
abstract class Enum {

    /**
     * Get all constant values.
     *
     * @return array
     * @throws \ReflectionException
     */
    static function getValues() {
        $class = new \ReflectionClass(get_called_class());
        return array_values($class->getConstants());
    }
}
