<?php
$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "myTestDb2"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $role = 0; 

    $checkLoginSql = "SELECT * FROM `login` WHERE `Логин` = '$login'";
    $result = $conn->query($checkLoginSql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Логин занят. Пожалуйста, выберите другой.');window.location.href = 'register.html';</script>";
    } else {
        $sql = "INSERT INTO `login` (`Логин`, `Пароль`, `Роль`) VALUES ('$login', '$password', '$role')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script> 
            alert('Регистрация прошла успешно!'); 
            window.location.href = 'login.html';
            </script>";
        } else {
            echo "<div style='color: red; font-weight: bold;'>Ошибка при вставке в таблицу Авторизация: " . $conn->error . "</div>";
        }
    }
}

$conn->close(); 
?>