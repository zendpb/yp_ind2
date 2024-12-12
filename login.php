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
    
    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = "SELECT `Пароль`, `Роль` FROM `login` WHERE `Логин` = '$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['Пароль']) {
            $роль = $row['Роль'];
            if ($роль == 1) {
                echo "<script>
                        window.location.href = 'edit.html';                 //sdasdasdasdasd
                      </script>";
            } else {
                echo "<script>
                        window.location.href = 'view.html';         //asdsadasdasdasd
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Неправильный пароль');
                    window.location.href = 'login.html';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Такого логина нету, зарегистрируйтесь');
                window.location.href = 'login.html';
              </script>";
    }
}

$conn->close(); 
?>