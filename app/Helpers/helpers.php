<?php
if (!function_exists('getPath')) {
    function getPath($file) {
        if (is_file(public_path($file))) {
            return $file;
        }
        return null;
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

if (!function_exists('getDefaultBannerImage')) {
    function getDefaultBannerImage($image): string {
        return asset(getPath($image) ?? 'assets/img/banner-bg.jpg');
    }
}

if (!function_exists('getBannerImage')) {
    function getBannerImage($image, $setting): string {
        if ($image = getPath($image)) {
            return asset($image);
        }
        return getDefaultBannerImage($setting);
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
