<?php

namespace App\Helpers;

class Widgets
{
    const HOLIDAY_REQUEST = 1;
    const WEATHER = 2;
    const TRADINGVIEW = 3;
    const CORPORATE_NEWS = 4;

    public static function getAllWidgets() {
        return [
            self::HOLIDAY_REQUEST => 'Holiday Request',
            self::WEATHER => 'Weather',
            self::TRADINGVIEW => 'Trading View',
            self::CORPORATE_NEWS => 'Corporate News',
        ];
    }

    public static function getWidgetsRule() {
        return 'in:'.implode(',', array_keys(self::getAllWidgets()));
    }
}
