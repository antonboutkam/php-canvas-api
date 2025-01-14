<?php

namespace Hurah\Canvas\Endpoints;

use DateTime;
use Hurah\Canvas\Util;
use Hurah\Types\Exception\NullPointerException;
use ReflectionClass;

abstract class CanvasObject
{

    public function toCanvasArray():array
    {
        return [
            'assignment' => $this->toArray()
        ];
    }

    /**
     * Converts the object properties into an array.
     *
     * @param string $keyStyle The style in which the keys should be formatted (default is 'snake_case')
     * @return array The array representation of the object properties
     */
    public function toArray(string $keyStyle = 'snake_case'):array
    {
        $aOut = [];
        $refclass = new ReflectionClass($this);
        foreach ($refclass->getProperties() as $property)
        {

            $keyName = $property->name;
            if($keyStyle === 'snake_case')
            {
                $keyName = Util::camelCaseToUnderscore($property->name);
            }
            if($property->getType() === null)
            {
                echo $property->name . ' has no type'. PHP_EOL;
            }

            if($property->getType()->getName() === 'DateTime')
            {
                $aOut[$keyName] = self::formatDt($property->getValue($this));
            }
            else
            {
                $aOut[$keyName] = $property->getValue($this);
            }

        }
        return $aOut;
    }

    protected static function formatDt(?DateTime $dt = null):?string
    {
        if($dt)
        {
            return $dt->format(\DateTime::ATOM);
        }
        return null;
    }
    protected static function makeDate(?string $dateTime = null):?DateTime
    {
        if(!$dateTime)
        {
            return null;
        }
        $dateTime = preg_replace('/Z$/', '', $dateTime);
        return DateTime::createFromFormat('Y-m-d\TH:i:s', $dateTime);
    }



    protected static function _setValue($instance, $key, $method, $value)
    {

        if (empty($value)) {
            return;
        }
        if (!method_exists($instance, $method)) {
            echo '---- No method ' . get_class($instance) . ' -- ' . $method  . PHP_EOL;
            return;
        }
        if (str_ends_with($method, 'At')) {
            $value = DateTime::createFromFormat('Y-m-d\TH:i:s', $value);
            if (!$value) {
                return;
            }

        }elseif (empty($value)) {
            return;
        }

        $instance->$method($value);
    }
}