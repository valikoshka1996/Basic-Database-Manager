<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['db']) && isset($_POST['table'])) {
    $selectedDatabase = $_POST['db'];
    $selectedTable = $_POST['table'];

    // Підключення до вибраної бази даних
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $selectedDatabase);

    // Перевірка підключення
    if ($conn->connect_error) {
        die("Помилка підключення до бази даних: " . $conn->connect_error);
    }

    // Підготовка запиту на вставку даних
    $fields = array_keys($_POST);
    $values = array_map(function($value) use ($conn) {
        return "'" . $conn->real_escape_string($value) . "'";
    }, $_POST);

    $insertQuery = "INSERT INTO $selectedTable (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")";

    // Виконання запиту на вставку
    if ($conn->query($insertQuery) === TRUE) {
        echo "Новий запис успішно створено.";
    } else {
        echo "Помилка створення запису: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Невірні параметри для створення запису.";
}
?>
