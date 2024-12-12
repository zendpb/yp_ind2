<?php
$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "myTestDb2"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['description'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);

    if ($id > 0) {
        // Update existing record
        $updateSql = "UPDATE `data` SET `name` = '$name', `description` = '$description' WHERE `id` = $id";
        if ($conn->query($updateSql) === TRUE) {
            echo "<script>
                    alert('Данные успешно обновлены!');
                    window.location.href = 'edit.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Ошибка обновления: " . $conn->error . "');
                    window.location.href = 'edit.html';
                  </script>";
        }
    } else {
        // Insert new record
        $insertSql = "INSERT INTO `data` (`name`, `description`) VALUES ('$name', '$description')";
        if ($conn->query($insertSql) === TRUE) {
            echo "<script>
                    alert('Данные успешно добавлены!');
                    window.location.href = 'edit.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Ошибка добавления: " . $conn->error . "');
                    window.location.href = 'edit.html';
                  </script>";
        }
    }
} else {
    echo '<style>
            body {
                font-family: "Times New Roman", Times, serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f0f8ff;
                margin: 0;
            }
            .edit-container {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 350px;
            }
            .edit-container h2 {
                text-align: center;
                margin-bottom: 20px;
            }
            .edit-container input[type="text"] {
                width: 92%;
                padding: 10px;
                margin: 10px 0; 
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .edit-container button {
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                border: none;
                border-radius: 5px;
                background-color: #0097a7;
                color: white;
                cursor: pointer;
                font-size: 16px;
            }
          </style>';

    if ($id > 0) {
        // Fetch existing record for editing
        $sql = "SELECT * FROM `data` WHERE `id` = $id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<div class="edit-container">
                    <h2>Редактировать данные</h2>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">
                        <input type="text" name="name" value="' . htmlspecialchars($row['name']) . '" required placeholder="Название">
                        <input type="text" name="description" value="' . htmlspecialchars($row['description']) . '" required placeholder="Описание">
                        <button type="submit">Сохранить изменения</button>
                    </form>
                  </div>';
        } else {
            echo "<p>Данные не найдены.</p>";
        }
    } else {
        // Form for adding new record
        echo '<div class="edit-container">
                <h2>Добавить данные</h2>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="0">
                    <input type="text" name="name" required placeholder="Название">
                    <input type="text" name="description" required placeholder="Описание">
                    <button type="submit">Добавить данные</button>
                </form>
              </div>';
    }
}

$conn->close();
?>