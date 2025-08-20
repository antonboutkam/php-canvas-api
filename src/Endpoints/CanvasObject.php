<?php

namespace Hurah\Canvas\Endpoints;

use DateTime;
use DateTimeInterface;
use Hurah\Canvas\Util;
use ReflectionClass;

abstract class CanvasObject
{


    /**
     * Converts a snake_case string to lowerCamelCase.
     *
     * @param string $string
     * @return string
     */
    protected static function snakeToCamel(string $string): string
    {
        return lcfirst(str_replace('_', '', ucwords($string, '_')));
    }

    /**
     * Converts a snake_case string to lowerCamelCase.
     *
     * @param string $string
     * @return string
     */
    protected static function snakeToSetter(string $string): string
    {
        return 'set' . ucfirst(str_replace('_', '', ucwords($string, '_')));
    }

    protected static function makeDate(?string $dateTime = null): ?DateTime
    {
        if (!$dateTime) {
            return null;
        }
        $dateTime = preg_replace('/Z$/', '', $dateTime);
        if (strpos($dateTime, '+')) {
            $dateTime = explode('+', $dateTime)[0];
        }

        return DateTime::createFromFormat('Y-m-d\TH:i:s', $dateTime);
    }

    protected static function _setValue($instance, $key, $method, $value): void
    {

        if (empty($value)) {
            return;
        }

        if (!method_exists($instance, $method)) {
            echo '---- No method ' . get_class($instance) . ' -- ' . $method  . ' to set value ' . gettype($value) .
            PHP_EOL;
            return;
        }
        if (str_ends_with($method, 'At')) {
            $value = DateTime::createFromFormat('Y-m-d\TH:i:s', $value);
            if (!$value) {
                return;
            }

        }

        $instance->$method($value);
    }

    /**
     * Converts the object properties into an array.
     *
     * @param string $keyStyle The style in which the keys should be formatted (default is 'snake_case')
     * @return array The array representation of the object properties
     */
    public function toArray(string $keyStyle = 'snake_case'): array
    {
        $aOut = [];
        $reflector = new ReflectionClass($this);
        foreach ($reflector->getProperties() as $property) {

            $keyName = $property->name;
            if ($keyStyle === 'snake_case') {
                $keyName = Util::camelCaseToUnderscore($property->name);
            }
            if ($property->getType() === null) {
                echo 'Property: ' . $property->name . ' has no type' . PHP_EOL;
                continue;
            }

            if ($property->getType()->getName() === 'DateTime') {
                $aOut[$keyName] = self::formatDt($property->getValue($this));
            } else if($property->isInitialized()) {

                $aOut[$keyName] = $property->getValue($this);
            }

        }
        return $aOut;
    }

    protected static function formatDt(?DateTime $dt = null): ?string
    {
        return $dt?->format(DateTimeInterface::ATOM);
    }

    /**
     * Converts array keys to a specified case format.
     *
     * @param array $data The original array.
     * @param string $format The desired case format.
     * @return array
     */
    protected function convertArrayKeys(array $data, string $format): array
    {
        $formattedData = [];

        foreach ($data as $key => $value) {
            switch ($format) {
                case 'UPPER_SNAKE_CASE':
                    $newKey = strtoupper(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));
                    break;
                case 'lower_snake_case':
                    $newKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));
                    break;
                case 'CamelCase':
                    $newKey = ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
                    break;
                case 'camelCase':
                default:
                    $newKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
                    break;
            }

            $formattedData[$newKey] = $value;
        }

        return $formattedData;
    }
}