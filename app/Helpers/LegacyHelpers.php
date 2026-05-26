<?php

/**
 * Helper functions for legacy code compatibility
 */

if (!function_exists('get_koneksi')) {
    function get_koneksi()
    {
        global $koneksi;
        return $koneksi ?? app('legacy.db');
    }
}

if (!function_exists('redirect_to')) {
    function redirect_to($url)
    {
        header("Location: " . $url);
        exit;
    }
}

if (!function_exists('get_session')) {
    function get_session($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }
}

if (!function_exists('set_session')) {
    function set_session($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}

if (!function_exists('unset_session')) {
    function unset_session($key)
    {
        unset($_SESSION[$key]);
    }
}

if (!function_exists('session_exists')) {
    function session_exists($key)
    {
        return isset($_SESSION[$key]);
    }
}

if (!function_exists('get_request')) {
    function get_request($key, $method = 'GET', $default = null)
    {
        if ($method === 'GET') {
            return $_GET[$key] ?? $default;
        } elseif ($method === 'POST') {
            return $_POST[$key] ?? $default;
        } elseif ($method === 'REQUEST') {
            return $_REQUEST[$key] ?? $default;
        }
        return $default;
    }
}

if (!function_exists('escape_output')) {
    function escape_output($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('get_asset_url')) {
    function get_asset_url($path)
    {
        return asset($path);
    }
}

if (!function_exists('get_base_url')) {
    function get_base_url($path = '')
    {
        return url($path);
    }
}

if (!function_exists('die_json')) {
    function die_json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

if (!function_exists('success_response')) {
    function success_response($message = 'Success', $data = null)
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];
    }
}

if (!function_exists('error_response')) {
    function error_response($message = 'Error', $data = null)
    {
        return [
            'success' => false,
            'message' => $message,
            'data' => $data
        ];
    }
}

if (!function_exists('get_db_date')) {
    function get_db_date($datetime = null)
    {
        if (!$datetime) {
            $datetime = date('Y-m-d H:i:s');
        }
        return date('Y-m-d H:i:s', strtotime($datetime));
    }
}

if (!function_exists('format_date')) {
    function format_date($datetime, $format = 'd/m/Y')
    {
        if (empty($datetime)) {
            return '-';
        }
        return date($format, strtotime($datetime));
    }
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($input)
    {
        if (is_array($input)) {
            return array_map('sanitize_input', $input);
        }
        return trim(stripslashes($input));
    }
}
