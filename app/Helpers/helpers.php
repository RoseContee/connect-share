<?php
if (!function_exists('getPath')) {
    function getPath($file) {
        return is_file(public_path($file)) ? $file : null;
    }
}

if (!function_exists('getFavicon')) {
    function getFavicon($favicon): string {
        return asset(getPath($favicon) ?? 'favicon.ico');
    }
}

if (!function_exists('getLogo')) {
    function getLogo($logo): string {
        return asset(getPath($logo) ?? 'assets/img/logo.png');
    }
}

if (!function_exists('getBannerImage')) {
    function getBannerImage($image, $default = null): string {
        return asset(getPath($image) ?? getPath($default) ?? 'assets/img/banner-bg.jpg');
    }
}

if (!function_exists('byte_format')) {
    function byte_formate($byte): string {
        if ($byte < 1024) return round($byte, 2).' bytes';
        $byte /= 1024;
        if ($byte < 1024) return round($byte, 2).' KB';
        $byte /= 1024;
        if ($byte < 1024) return round($byte, 2).' MB';
        $byte /= 1024;
        if ($byte < 1024) return round($byte, 2).' GB';
        $byte /= 1024;
        return round($byte, 2).' TB';
    }
}
