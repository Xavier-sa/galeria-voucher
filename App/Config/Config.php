<?php

class Config
{
    private static ?array $settings = null;

    private static function load(): void
    {
        if (self::$settings !== null) return;

        $defaults = [
            'APP_URL' => 'auto',
            'DIR_IMG' => 'App/View/assets/img/',
            'DIR_CSS' => 'App/View/assets/css/',
            'DIR_JS' => 'App/View/assets/js/',
            'DIR_ADM' => 'App/View/pages/adm/',
            'DIR_USER' => 'App/View/pages/users/',
            'DIR_LOGOUT' => 'App/View/includes/',
        ];
        $projectRoot = dirname(__DIR__, 2);
        $envFile = is_file($projectRoot . '/.env.local') ? $projectRoot . '/.env.local' : $projectRoot . '/.env';
        $fileSettings = is_file($envFile) ? (parse_ini_file($envFile, false, INI_SCANNER_RAW) ?: []) : [];
        self::$settings = $defaults;
        foreach ($defaults as $key => $default) {
            $environmentValue = getenv($key);
            self::$settings[$key] = $environmentValue !== false ? $environmentValue : ($fileSettings[$key] ?? $default);
        }
    }

    private static function get(string $key): ?string
    {
        self::load();
        return self::$settings[$key] ?? null;
    }

    private static function detectAppUrl(): string
    {
        $https = ($_SERVER['HTTPS'] ?? '') !== '' && ($_SERVER['HTTPS'] ?? '') !== 'off';
        $scheme = $https ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
        $projectRoot = realpath(dirname(__DIR__, 2)) ?: '';
        $basePath = '';
        if ($documentRoot !== '' && str_starts_with($projectRoot, $documentRoot)) {
            $basePath = str_replace(DIRECTORY_SEPARATOR, '/', substr($projectRoot, strlen($documentRoot)));
        }
        $path = trim($basePath, '/');
        return $scheme . '://' . $host . '/' . ($path === '' ? '' : $path . '/');
    }

    public static function getAppUrl(): string
    {
        $configuredUrl = trim((string) self::get('APP_URL'));
        return $configuredUrl === '' || strtolower($configuredUrl) === 'auto'
            ? self::detectAppUrl()
            : rtrim($configuredUrl, '/') . '/';
    }

    public static function getDirImg(): string { return self::getAppUrl() . self::get('DIR_IMG'); }
    public static function getDirCss(): string { return self::getAppUrl() . self::get('DIR_CSS'); }
    public static function getDirJs(): string { return self::getAppUrl() . self::get('DIR_JS'); }
    public static function getDirAdm(): string { return self::getAppUrl() . self::get('DIR_ADM'); }
    public static function getDirUser(): string { return self::getAppUrl() . self::get('DIR_USER'); }
    public static function getDirLogout(): string { return self::getAppUrl() . self::get('DIR_LOGOUT'); }
}
