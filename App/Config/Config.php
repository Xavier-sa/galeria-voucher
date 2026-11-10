<?php

require_once __DIR__ . '/Environment.php';

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
        self::$settings = $defaults;
        foreach ($defaults as $key => $default) {
            self::$settings[$key] = Environment::get($key, $default);
        }
    }

    private static function get(string $key): ?string
    {
        self::load();
        return self::$settings[$key] ?? null;
    }

    private static function detectAppUrl(): string
    {
        $forwardedProto = strtolower(trim(explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')[0]));
        $https = $forwardedProto === 'https'
            || (($_SERVER['HTTPS'] ?? '') !== '' && strtolower((string) $_SERVER['HTTPS']) !== 'off')
            || (string) ($_SERVER['SERVER_PORT'] ?? '') === '443';
        $scheme = $https ? 'https' : 'http';
        $forwardedHost = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_HOST'] ?? '')[0]);
        $host = $forwardedHost !== '' ? $forwardedHost : ($_SERVER['HTTP_HOST'] ?? 'localhost');
        if (!preg_match('/^[a-z0-9.\-:\[\]]+$/i', $host)) {
            $host = 'localhost';
        }
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
