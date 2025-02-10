<?php

namespace Hurah\Canvas;

class Util
{
    public static function underscoreToCamelCase($string, $capitalizeFirstCharacter = false): array|string
    {
        $string = str_replace('-', ' ', $string);
        $string = str_replace('_', ' ', $string);
        $str = str_replace(' ', '', ucwords($string));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
    public static function camelCaseToUnderscore($string)
    {
        $result = preg_replace('/(?<=\\w)(?=[A-Z])/',"_$1", $string);
        return mb_strtolower($result);
    }

    public static function slugify($string, $delimiter = '-') {
        // Convert all special characters to ASCII
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        // Replace all non-word characters with the delimiter
        $string = preg_replace('/\W+/', $delimiter, $string);
        // Lowercase and return
        return strtolower(trim($string, $delimiter));
    }

}