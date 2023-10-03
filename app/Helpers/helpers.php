<?php
if (!function_exists('getFavicon')) {
    function getFavicon($favicon) {
        if ($favicon && file_exists(public_path($favicon))) {
            return asset($favicon);
        }
        return asset('favicon.ico');
    }
}

if (!function_exists('getLogo')) {
    function getLogo($logo) {
        if ($logo && file_exists(public_path($logo))) {
            return asset($logo);
        }
        return asset('assets/img/logo.png');
    }
}

if (!function_exists('getBannerImage')) {
    function getBannerImage($image) {
        if ($image && file_exists(public_path($image))) {
            return asset($image);
        }
        return asset('assets/img/banner-bg.jpg');
    }
}

if (!function_exists('byte_format')) {
    function byte_formate($byte) {
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
