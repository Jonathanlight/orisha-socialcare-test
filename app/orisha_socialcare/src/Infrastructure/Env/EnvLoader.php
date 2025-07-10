<?php

declare(strict_types=1);

namespace App\Infrastructure\Env;

class EnvLoader
{
    public static function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException(".env file not found: $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!is_array($lines)) {
            throw new \RuntimeException("Impossible de charger le fichier .env");
        }

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
            putenv(trim($key).'='.trim($value));
        }
    }
}
