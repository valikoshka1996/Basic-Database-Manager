<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['db']) && isset($_POST['table']) && isset($_POST['id'])) {
    $selectedDatabase = $_POST['db'];
    $selectedTable = $_POST['table'];
    $recordId = $_POST['id'];

    // Підключення до вибраної бази даних
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $selectedDatabase);

    // Перевірка підключення
    if ($conn->connect_error) {
        die("Помилка підключення до бази даних: " . $conn->connect_error);
    }

    // Підготовка запиту на оновлення даних
    $updateQuery = "UPDATE $selectedTable SET ";
    $fields = array_keys($_POST);
    $first = true;
    foreach ($fields as $field) {
        if ($field != 'db' && $field != 'table' && $field != 'id') {
            if (!$first) {
                $updateQuery .= ", ";
            }
            $updateQuery .= "$field='" . $conn->real_escape_string($_POST[$field]) . "'";
            $first = false;
        }
    }
    $updateQuery .= " WHERE id=$recordId";

    // Виконання запиту на оновлення
    if ($conn->query($updateQuery) === TRUE) {
        echo "Запис успішно оновлено.";
    } else {
        echo "Помилка оновлення запису: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Невірні параметри для оновлення запису.";
}
?>
