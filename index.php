<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Management</title>
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
        <h2 class="my-4">Database Management System</h2>

        <?php
        require_once 'config.php';

        // Підключення до MySQL сервера
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

        // Перевірка підключення
        if ($conn->connect_error) {
            die("Помилка підключення до бази даних: " . $conn->connect_error);
        }

        // Отримання списку баз даних
        $result = $conn->query("SHOW DATABASES");

        if ($result->num_rows > 0) {
            echo "<h4>Список баз даних:</h4>";
            echo "<ul class='list-group mb-4'>";
            while ($row = $result->fetch_assoc()) {
                $dbName = $row['Database'];
                echo "<li class='list-group-item'><a href='tables.php?db=$dbName'>$dbName</a></li>";
            }
            echo "</ul>";
        } else {
            echo "Немає доступних баз даних.";
        }

        $conn->close();
        ?>

    </div>
</body>
</html>
