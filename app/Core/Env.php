<?php
namespace App\Core;

class Env {
    public static function load($path) {
        if (!file_exists($path)) return;

        foreach (file($path, FILE_IGNORE_NEW_LINES) as $line) {
            if (empty($line) || $line[0] === '#')  continue;
            [$key, $value] = explode('=', $line, 2);
            $_ENV[$key] = trim($value);
        }
    }

    public static function get($key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}
