<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Record</title>
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
        <h2 class="my-4">Edit Record</h2>

        <?php
        require_once 'config.php';

        // Перевірка наявності параметрів db, table і id в запиті GET
        if (isset($_GET['db']) && isset($_GET['table']) && isset($_GET['id'])) {
            $selectedDatabase = $_GET['db'];
            $selectedTable = $_GET['table'];
            $recordId = $_GET['id'];

            // Підключення до вибраної бази даних
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, $selectedDatabase);

            // Перевірка підключення
            if ($conn->connect_error) {
                die("Помилка підключення до бази даних: " . $conn->connect_error);
            }

            // Отримання даних редагування з вибраної таблиці
            $result = $conn->query("SELECT * FROM $selectedTable WHERE id = $recordId");

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<form action='update.php' method='post'>";
                echo "<input type='hidden' name='db' value='$selectedDatabase'>";
                echo "<input type='hidden' name='table' value='$selectedTable'>";
                echo "<input type='hidden' name='id' value='$recordId'>";
                foreach ($row as $field => $value) {
                    echo "<div class='form-group'>";
                    echo "<label for='$field'>$field</label>";
                    echo "<input type='text' class='form-control' id='$field' name='$field' value='$value' required>";
                    echo "</div>";
                }
                echo "<button type='submit' class='btn btn-primary'>Оновити</button>";
                echo "</form>";
            } else {
                echo "Не вдалося знайти запис для редагування.";
            }

            $conn->close();
        } else {
            echo "Невірні параметри для редагування запису.";
        }
        ?>

        <a href="manage.php?db=<?php echo $selectedDatabase; ?>&table=<?php echo $selectedTable; ?>" class="btn btn-secondary mt-3">Назад</a>
    </div>
</body>
</html>
