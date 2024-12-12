<?php
$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "myTestDb2"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$sql = "SELECT * FROM `data`";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Название</th><th>Описание</th><th>Создано</th><th>Отредактировано</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Данные не найдены.</p>";
}

$conn->close();
?>