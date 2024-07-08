<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Table Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 800px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="my-3">Table Management</h2>

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

            // Отримання даних з вибраної таблиці
            $result = $conn->query("SELECT * FROM $selectedTable");

            if ($result->num_rows > 0) {
                echo "<h4>Записи в таблиці '$selectedTable':</h4>";
                echo "<table class='table table-bordered'>";
                echo "<thead class='thead-light'><tr>";
                // Виведення заголовків таблиці (назви полів)
                while ($fieldinfo = $result->fetch_field()) {
                    echo "<th scope='col'>$fieldinfo->name</th>";
                }
                echo "<th scope='col'>Дії</th>";
                echo "</tr></thead>";
                echo "<tbody>";
                // Виведення даних таблиці
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "<td><a href='edit.php?db=$selectedDatabase&table=$selectedTable&id={$row['id']}' class='btn btn-sm btn-primary'>Редагувати</a> ";
                    echo "<a href='delete.php?db=$selectedDatabase&table=$selectedTable&id={$row['id']}' class='btn btn-sm btn-danger'>Видалити</a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "Немає записів у таблиці '$selectedTable'.";
            }

            $conn->close();
        } else {
            echo "Невірні параметри для вибору таблиці.";
        }
        ?>

        <a href="tables.php?db=<?php echo $selectedDatabase; ?>" class="btn btn-secondary">Назад</a>
        <a href="index.php" class="btn btn-secondary">На головну</a>
        <a href="create.php?db=<?php echo $selectedDatabase; ?>&table=<?php echo $selectedTable; ?>" class="btn btn-success float-right">Додати запис</a>
    </div>
</body>
</html>
