<?php

namespace Hurah\Canvas;

use Hurah\Types\Type\Url;

class Config
{
    public static function getAccountId():?string
    {
        return $_ENV['CANVAS_ACCOUNT_ID'] ?? null;
    }

    public static function getCanvasToken():string
    {
        return $_ENV['CANVAS_API'];
    }
    public static function getCanvasUrl():Url
    {
        return new Url($_ENV['CANVAS_URL']);
    }
}
