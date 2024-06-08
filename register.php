<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo "Регистрация успешна. Теперь вы можете <a href='index.html'>войти</a>.";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Пожалуйста, заполните оба поля.";
}

$conn->close();
?>
