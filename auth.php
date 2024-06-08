<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productshop";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка на учетную запись администратора
    if ($username === 'admin' && $password === '12345') {
        header("Location: adminPage.html");
        exit();
    }

    // Подготовка и выполнение запроса
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Проверка пароля
    if ($hashed_password && password_verify($password, $hashed_password)) {
        header("Location: ordersPage.php");
        exit();
    } else {
        echo "Неверный логин или пароль";
    }

    $stmt->close();
} else {
    echo "Пожалуйста, заполните оба поля.";
}

$conn->close();
?>
