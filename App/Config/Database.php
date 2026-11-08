<?php
class Database
{
    private static $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $projectRoot = dirname(__DIR__, 2);
        $envFile = is_file($projectRoot . '/.env.local') ? $projectRoot . '/.env.local' : $projectRoot . '/.env';
        $env = is_file($envFile) ? (parse_ini_file($envFile, false, INI_SCANNER_RAW) ?: []) : [];
        $value = static function (string $key, string $default) use ($env): string {
            $environmentValue = getenv($key);
            return $environmentValue !== false ? $environmentValue : (string) ($env[$key] ?? $default);
        };

        $host = $value('DB_HOST', '127.0.0.1');
        $port = $value('DB_PORT', '5432');
        $dbname = $value('DB_DATABASE', 'galeria_voucher');
        $user = $value('DB_USERNAME', 'root');
        $pass = $value('DB_PASSWORD', '');
        $connection = $value('DB_CONNECTION', 'pgsql');
        $sslmode = $value('DB_SSLMODE', 'require');
        $databaseUrl = $value('DATABASE_URL', '');

        if ($connection !== 'pgsql') {
            throw new RuntimeException("DB_CONNECTION deve ser 'pgsql' para usar o Neon PostgreSQL.");
        }

        if (!in_array('pgsql', PDO::getAvailableDrivers(), true)) {
            throw new RuntimeException('O driver PDO PostgreSQL (pdo_pgsql) não está instalado ou habilitado no PHP.');
        }

        if ($databaseUrl !== '') {
            $parts = parse_url($databaseUrl);
            if ($parts === false || !isset($parts['host'], $parts['path'], $parts['user'])) {
                throw new RuntimeException('DATABASE_URL possui um formato inválido.');
            }

            $host = $parts['host'];
            $port = (string) ($parts['port'] ?? 5432);
            $dbname = ltrim($parts['path'], '/');
            $user = rawurldecode($parts['user']);
            $pass = rawurldecode($parts['pass'] ?? '');

            if (isset($parts['query'])) {
                parse_str($parts['query'], $query);
                $sslmode = (string) ($query['sslmode'] ?? $sslmode);
            }
        }

        try {
            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode={$sslmode}";
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException("Não foi possível conectar ao banco de dados '{$dbname}' em {$host}:{$port}.", 0, $e);
        }

    }
    public static function conectar(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance->pdo;
    }
}
