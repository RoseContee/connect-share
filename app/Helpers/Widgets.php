<?php

namespace App\Helpers;

class Widgets
{
    const WEATHER = 1;
    const TRADINGVIEW = 2;
    const GMAIL_USE = 3;
    const HOLIDAY_REQUEST = 4;
    const CORPORATE_NEWS = 5;

    public static function getAllWidgets() {
        return [
            self::WEATHER => 'Weather',
            self::TRADINGVIEW => 'Trading View',
            self::GMAIL_USE => 'Gmail Use',
            self::HOLIDAY_REQUEST => 'Holiday Request',
            self::CORPORATE_NEWS => 'Corporate News',
        ];
    }

    public static function getWidgetsRule() {
        return 'in:'.implode(',', array_keys(self::getAllWidgets()));
    }
}
