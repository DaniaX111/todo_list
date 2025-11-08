<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

// Проверяем наличие файла .env
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    die("❌ Файл .env не найден");
}

// Проверяем наличие всех нужных переменных
$required = ['DBHOST', 'DBPORT', 'DBNAME', 'DBUSER', 'DBPASSWORD'];
foreach ($required as $key) {
    if (empty($_ENV[$key]) && $_ENV[$key] !== '0') {
        die("❌ Отсутствует переменная окружения: {$key}");
    }
}

try {
    // Формируем строку подключения
    $dsn = "mysql:host={$_ENV['DBHOST']};port={$_ENV['DBPORT']};dbname={$_ENV['DBNAME']};charset=utf8";

    // Подключаемся к базе
    $conn = new PDO(
        $dsn,
        $_ENV['DBUSER'],
        $_ENV['DBPASSWORD']
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Подключение к БД успешно<br>";
} catch (PDOException $e) {
    die("❌ Ошибка подключения к БД: " . $e->getMessage());
}
