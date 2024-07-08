<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Create New Record</h2>

        <?php
        require_once 'config.php';

        // Перевірка наявності параметрів db і table в запиті GET
        if (isset($_GET['db']) && isset($_GET['table'])) {
            $selectedDatabase = $_GET['db'];
            $selectedTable = $_GET['table'];

            // Підключення до вибраної бази даних
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $selectedDatabase);

            // Перевірка підключення
            if ($conn->connect_error) {
                die("Помилка підключення до бази даних: " . $conn->connect_error);
            }

            // Отримання структури вибраної таблиці
            $result = $conn->query("DESCRIBE $selectedTable");

            if ($result->num_rows > 0) {
                echo "<form action='insert.php' method='post'>";
                echo "<input type='hidden' name='db' value='$selectedDatabase'>";
                echo "<input type='hidden' name='table' value='$selectedTable'>";
                while ($row = $result->fetch_assoc()) {
                    $fieldName = $row['Field'];
                    echo "<div class='form-group'>";
                    echo "<label for='$fieldName'>$fieldName</label>";
                    echo "<input type='text' class='form-control' id='$fieldName' name='$fieldName' required>";
                    echo "</div>";
                }
                echo "<button type='submit' class='btn btn-primary'>Створити</button>";
                echo "</form>";
            } else {
                echo "Не вдалося отримати структуру таблиці '$selectedTable'.";
            }

            $conn->close();
        } else {
            echo "Невірні параметри для створення запису.";
        }
        ?>

        <a href="manage.php?db=<?php echo $selectedDatabase; ?>&table=<?php echo $selectedTable; ?>" class="btn btn-secondary mt-3">Назад</a>
    </div>
</body>
</html>
