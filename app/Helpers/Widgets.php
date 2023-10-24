<?php

namespace App\Helpers;

class Widgets
{
    const HOLIDAY_REQUEST = 1;
    const WEATHER = 2;
    const TRADINGVIEW = 3;

    const ALL = [
        self::HOLIDAY_REQUEST => 'Holiday Request',
        self::WEATHER => 'Weather',
        self::TRADINGVIEW => 'Trading View',
    ];

    public static function getAllWidgets() {
        return self::ALL;
    }

    public static function getWidgetsRule() {
        return 'in:'.implode(',', array_keys(self::ALL));
    }
}
