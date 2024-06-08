<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productshop";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$clients_sql = "SELECT * FROM clients";
$clients_result = $conn->query($clients_sql);

$products_sql = "SELECT * FROM products";
$products_result = $conn->query($products_sql);


$orders_sql = "SELECT * FROM orders";
$orders_result = $conn->query($orders_sql);


$suppliers_sql = "SELECT * FROM suppliers";
$suppliers_result = $conn->query($suppliers_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница заказов</title>
    <link rel="stylesheet" href="orders.css">
</head>
<body>
    <div class="data-container">
        <h1>Заказы</h1>

        <!-- Клиенты -->
        <h2>Клиенты</h2>
        <?php if ($clients_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Адрес</th>
                    <th>История покупок</th>
                </tr>
                <?php while($row = $clients_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['purchase_history']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Нет данных о клиентах.</p>
        <?php endif; ?>

        <!-- Продукты -->
        <h2>Продукты</h2>
        <?php if ($products_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Производитель/Поставщик</th>
                    <th>Срок годности/Дата производства</th>
                    <th>Описание</th>
                </tr>
                <?php while($row = $products_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['supplier']; ?></td>
                        <td><?php echo $row['expiry_date']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Нет данных о продуктах.</p>
        <?php endif; ?>

        <!-- Заказы -->
        <h2>Заказы</h2>
        <?php if ($orders_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Дата заказа</th>
                    <th>Клиент</th>
                    <th>Перечень продуктов</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                </tr>
                <?php while($row = $orders_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td><?php echo $row['client']; ?></td>
                        <td><?php echo $row['products']; ?></td>
                        <td><?php echo $row['total']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Нет данных о заказах.</p>
        <?php endif; ?>

        <!-- Поставщики -->
        <h2>Поставщики</h2>
        <?php if ($suppliers_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Адрес</th>
                </tr>
                <?php while($row = $suppliers_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Нет данных о поставщиках.</p>
        <?php endif; ?>
    </div>
</body>
</html>
