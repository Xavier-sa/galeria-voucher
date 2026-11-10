<?php
require_once __DIR__ . '/Environment.php';

class Database
{
    private static $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $value = static function (string $key, string $default): string {
            return (string) Environment::get($key, $default);
        };

        $host = $value('DB_HOST', '127.0.0.1');
        $port = $value('DB_PORT', '5432');
        $dbname = $value('DB_DATABASE', 'galeria_voucher');
        $user = $value('DB_USERNAME', 'root');
        $pass = $value('DB_PASSWORD', '');
        $connection = strtolower($value('DB_CONNECTION', 'pgsql'));
        $sslmode = $value('DB_SSLMODE', 'require');
        $databaseUrl = $value('DATABASE_URL', '');
        $connectionOptions = '';

        if (!in_array($connection, ['pgsql', 'mysql'], true)) {
            throw new RuntimeException("DB_CONNECTION deve ser 'pgsql' ou 'mysql'.");
        }

        if (!in_array($connection, PDO::getAvailableDrivers(), true)) {
            throw new RuntimeException("O driver PDO {$connection} não está instalado ou habilitado no PHP.");
        }

        if ($connection === 'pgsql' && trim($databaseUrl) !== '') {
            $databaseUrl = trim($databaseUrl, " \t\n\r\0\x0B\"'");
            $parts = parse_url($databaseUrl);
            if ($parts === false || !isset($parts['host'], $parts['path'], $parts['user'])) {
                throw new RuntimeException('DATABASE_URL possui um formato inválido.');
            }

            $host = $parts['host'];
            $port = (string) ($parts['port'] ?? 5432);
            $dbname = rawurldecode(ltrim($parts['path'], '/'));
            $user = rawurldecode($parts['user']);
            $pass = rawurldecode($parts['pass'] ?? '');

            if (isset($parts['query'])) {
                parse_str($parts['query'], $query);
                $sslmode = (string) ($query['sslmode'] ?? $sslmode);
                $connectionOptions = (string) ($query['options'] ?? '');
            }
        }

        // Versões antigas da libpq (como algumas distribuídas com XAMPP) não
        // suportam SNI. O Neon aceita o endpoint via options como fallback.
        if ($connectionOptions === '' && str_ends_with(strtolower($host), '.neon.tech')) {
            $endpoint = explode('.', $host, 2)[0];
            $endpoint = preg_replace('/-pooler$/', '', $endpoint);
            if (str_starts_with($endpoint, 'ep-')) {
                $connectionOptions = 'endpoint=' . $endpoint;
            }
        }

        try {
            foreach (['host' => $host, 'port' => $port, 'dbname' => $dbname, 'sslmode' => $sslmode] as $name => $part) {
                if ($part === '' || preg_match('/[;\r\n]/', $part)) {
                    throw new RuntimeException("Configuração inválida para {$name}.");
                }
            }

            $dsn = $connection === 'mysql'
                ? "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4;connect_timeout=10"
                : "pgsql:host={$host};port={$port};dbname={$dbname};sslmode={$sslmode};connect_timeout=10";
            if ($connection === 'pgsql' && $connectionOptions !== '') {
                if (preg_match('/[;\r\n]/', $connectionOptions)) {
                    throw new RuntimeException('Configuração inválida para options.');
                }
                $dsn .= ";options='{$connectionOptions}'";
            }
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
