<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productshop";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Продукт
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $supplier = $_POST['supplier'];
    $expiryDate = $_POST['expiryDate'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Клиент
    $clientName = $_POST['clientName'];
    $clientPhone = $_POST['clientPhone'];
    $clientEmail = $_POST['clientEmail'];
    $clientAddress = $_POST['clientAddress'];
    $purchaseHistory = $_POST['purchaseHistory'];

    // Заказ
    $orderDate = $_POST['orderDate'];
    $orderClient = $_POST['orderClient'];
    $orderProducts = $_POST['orderProducts'];
    $orderTotal = $_POST['orderTotal'];
    $orderStatus = $_POST['orderStatus'];

    // Поставщик
    $supplierName = $_POST['supplierName'];
    $supplierPhone = $_POST['supplierPhone'];
    $supplierEmail = $_POST['supplierEmail'];
    $supplierAddress = $_POST['supplierAddress'];


    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "Изображение успешно загружено.";
    } else {
        echo "Ошибка загрузки изображения.";
    }

    // Пример запросов на вставку данных в базу
    $sql_product = "INSERT INTO products (name, category, price, quantity, supplier, expiry_date, description, image) 
                    VALUES ('$productName', '$category', '$price', '$quantity', '$supplier', '$expiryDate', '$description', '$image')";
    $sql_client = "INSERT INTO clients (name, phone, email, address, purchase_history) 
                   VALUES ('$clientName', '$clientPhone', '$clientEmail', '$clientAddress', '$purchaseHistory')";
    $sql_order = "INSERT INTO orders (order_date, client, products, total, status) 
                  VALUES ('$orderDate', '$orderClient', '$orderProducts', '$orderTotal', '$orderStatus')";
    $sql_supplier = "INSERT INTO suppliers (name, phone, email, address) 
                     VALUES ('$supplierName', '$supplierPhone', '$supplierEmail', '$supplierAddress')";

    if ($conn->query($sql_product) === TRUE && $conn->query($sql_client) === TRUE && $conn->query($sql_order) === TRUE && $conn->query($sql_supplier) === TRUE) {
        echo "Данные успешно добавлены.";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}

$conn->close();
?>
