<?php

final class Environment
{
    private static ?array $values = null;

    public static function get(string $key, ?string $default = null): ?string
    {
        $serverValue = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        if ($serverValue !== false && $serverValue !== null) {
            return (string) $serverValue;
        }

        self::load();
        return array_key_exists($key, self::$values) ? self::$values[$key] : $default;
    }

    private static function load(): void
    {
        if (self::$values !== null) {
            return;
        }

        $root = dirname(__DIR__, 2);
        $file = is_file($root . '/.env.local') ? $root . '/.env.local' : $root . '/.env';
        self::$values = [];

        if (!is_file($file) || !is_readable($file)) {
            return;
        }

        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = array_map('trim', explode('=', $line, 2));
            if (!preg_match('/^[A-Z_][A-Z0-9_]*$/i', $key)) {
                continue;
            }

            if (strlen($value) >= 2 && (($value[0] === '"' && str_ends_with($value, '"')) || ($value[0] === "'" && str_ends_with($value, "'")))) {
                $value = substr($value, 1, -1);
            }
            self::$values[$key] = $value;
        }
    }
}
