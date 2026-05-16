<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('money')) {
    function money($value) {
        return 'S/. ' . number_format((float)$value, 2);
    }
}

if (!function_exists('public_url')) {
    function public_url() {
        if (!empty($_SERVER['HTTP_HOST']) && !empty($_SERVER['SCRIPT_NAME'])) {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $script_dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
            return $scheme . '://' . $_SERVER['HTTP_HOST'] . ($script_dir === '' ? '' : $script_dir);
        }

        return rtrim(APP_URL, '/') . '/public';
    }
}

if (!function_exists('app_url')) {
    function app_url($route = '', $params = []) {
        $base = public_url() . '/';

        if ($route !== '') {
            $params = array_merge(['url' => ltrim($route, '/')], $params);
        }

        return $base . ($params ? '?' . http_build_query($params) : '');
    }
}

if (!function_exists('asset_url')) {
    function asset_url($path) {
        return public_url() . '/' . ltrim((string)$path, '/');
    }
}

if (!function_exists('product_image')) {
    function product_image($image) {
        if (empty($image)) {
            return asset_url('images/placeholder-product.png');
        }

        // External URLs (Unsplash, etc.) — return as-is
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        // Local file
        $full_path = PUBLIC_PATH . 'images/' . $image;
        if (file_exists($full_path)) {
            return asset_url('images/' . $image);
        }

        return asset_url('images/placeholder-product.png');
    }
}

if (!function_exists('flash')) {
    function flash($key) {
        if (!isset($_SESSION[$key])) {
            return null;
        }

        $message = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $message;
    }
}
