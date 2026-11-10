<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once dirname(__DIR__) . '/App/Config/Environment.php';
require_once dirname(__DIR__) . '/App/Config/Database.php';

$checks = [
    'PHP >= 8.1' => version_compare(PHP_VERSION, '8.1.0', '>='),
    'Extensão PDO' => extension_loaded('pdo'),
    'Driver pdo_pgsql' => in_array('pgsql', PDO::getAvailableDrivers(), true),
    'DATABASE_URL ou DB_HOST' => trim((string) Environment::get('DATABASE_URL', '')) !== ''
        || trim((string) Environment::get('DB_HOST', '')) !== '',
    'Diretório Uploads gravável' => is_dir(dirname(__DIR__) . '/Uploads')
        ? is_writable(dirname(__DIR__) . '/Uploads')
        : is_writable(dirname(__DIR__)),
];

$failed = false;
foreach ($checks as $label => $ok) {
    echo sprintf("[%s] %s\n", $ok ? 'OK' : 'ERRO', $label);
    $failed = $failed || !$ok;
}

if (!$failed) {
    try {
        $pdo = Database::conectar();
        $result = $pdo->query('SELECT current_database(), version()')->fetch(PDO::FETCH_NUM);
        echo "[OK] Conexão Neon: banco {$result[0]}\n";
    } catch (Throwable $e) {
        echo "[ERRO] Conexão Neon: {$e->getMessage()}\n";
        if ($e->getPrevious() !== null) {
            echo "       Causa: {$e->getPrevious()->getMessage()}\n";
        }
        $failed = true;
    }
}

exit($failed ? 1 : 0);
