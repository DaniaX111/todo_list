<?php
require __DIR__ . '/dbconnect.php';

$tables = ['Clients', 'Client_сheck', 'Deal', 'Tickers', 'Zayavka'];

foreach ($tables as $table) {
    echo "<h2>Таблица: $table</h2>";

    try {
        $result = $conn->query("SELECT * FROM $table");
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) === 0) {
            echo "<p>Нет данных в таблице</p>";
            continue;
        }

        // Заголовки таблицы
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>";
        foreach (array_keys($rows[0]) as $column) {
            echo "<th>" . htmlspecialchars($column) . "</th>";
        }
        echo "</tr>";

        // Данные таблицы
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }

        echo "</table><br><br>";

    } catch (PDOException $e) {
        echo "<p style='color:red'>Ошибка при запросе к $table: " . $e->getMessage() . "</p>";
    }
}
