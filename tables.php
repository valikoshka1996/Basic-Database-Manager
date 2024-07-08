<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tables Management</title>
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
        <h2 class="my-4">Tables Management</h2>

        <?php
        require_once 'config.php';

        // Перевірка наявності параметра db в запиті GET
        if (isset($_GET['db'])) {
            $selectedDatabase = $_GET['db'];

            // Підключення до вибраної бази даних
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $selectedDatabase);

            // Перевірка підключення
            if ($conn->connect_error) {
                die("Помилка підключення до бази даних: " . $conn->connect_error);
            }

            // Отримання списку таблиц у вибраній базі даних
            $result = $conn->query("SHOW TABLES");

            if ($result->num_rows > 0) {
                echo "<h4>Список таблиц у базі даних '$selectedDatabase':</h4>";
                echo "<ul class='list-group mb-4'>";
                while ($row = $result->fetch_row()) {
                    $tableName = $row[0];
                    echo "<li class='list-group-item'><a href='manage.php?db=$selectedDatabase&table=$tableName'>$tableName</a></li>";
                }
                echo "</ul>";
            } else {
                echo "Немає таблиць у базі даних '$selectedDatabase'.";
            }

            $conn->close();
        } else {
            echo "Невірні параметри для вибору бази даних.";
        }
        ?>

        <a href="index.php" class="btn btn-secondary">Назад</a>
    </div>
</body>
</html>
