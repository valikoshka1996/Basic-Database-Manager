<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['db']) && isset($_GET['table']) && isset($_GET['id'])) {
    $selectedDatabase = $_GET['db'];
    $selectedTable = $_GET['table'];
    $recordId = $_GET['id'];

    // Підключення до вибраної бази даних
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $selectedDatabase);

    // Перевірка підключення
    if ($conn->connect_error) {
        die("Помилка підключення до бази даних: " . $conn->connect_error);
    }

    // Підготовка запиту на видалення запису
    $deleteQuery = "DELETE FROM $selectedTable WHERE id=$recordId";

    // Виконання запиту на видалення
    if ($conn->query($deleteQuery) === TRUE) {
        echo "Запис успішно видалено.";
    } else {
        echo "Помилка видалення запису: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Невірні параметри для видалення запису.";
}
?>
