<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Инициализация фильтров
$client_filter = $product_filter = $order_filter = $supplier_filter = "";
$search_query = "";

// Обработка фильтров
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['client_name'])) {
        $client_name = $conn->real_escape_string($_POST['client_name']);
        $client_filter = "WHERE name LIKE '%$client_name%'";
    }

    if (isset($_POST['product_category'])) {
        $product_category = $conn->real_escape_string($_POST['product_category']);
        $product_filter = "WHERE category = '$product_category'";
    }

    if (isset($_POST['order_status'])) {
        $order_status = $conn->real_escape_string($_POST['order_status']);
        $order_filter = "WHERE status = '$order_status'";
    }

    if (isset($_POST['supplier_name'])) {
        $supplier_name = $conn->real_escape_string($_POST['supplier_name']);
        $supplier_filter = "WHERE name LIKE '%$supplier_name%'";
    }

    if (isset($_POST['search_query'])) {
        $search_query = $conn->real_escape_string($_POST['search_query']);
    }
}

// Поиск и фильтрация данных
$clients_sql = "SELECT * FROM clients $client_filter";
if ($search_query) {
    $clients_sql = "SELECT * FROM clients WHERE name LIKE '%$search_query%' OR phone LIKE '%$search_query%' OR email LIKE '%$search_query%' OR address LIKE '%$search_query%' OR purchase_history LIKE '%$search_query%'";
}
$clients_result = $conn->query($clients_sql);

$products_sql = "SELECT * FROM products $product_filter";
if ($search_query) {
    $products_sql = "SELECT * FROM products WHERE name LIKE '%$search_query%' OR category LIKE '%$search_query%' OR price LIKE '%$search_query%' OR quantity LIKE '%$search_query%' OR supplier LIKE '%$search_query%' OR expiry_date LIKE '%$search_query%' OR description LIKE '%$search_query%'";
}
$products_result = $conn->query($products_sql);

$orders_sql = "SELECT * FROM orders $order_filter";
if ($search_query) {
    $orders_sql = "SELECT * FROM orders WHERE order_date LIKE '%$search_query%' OR client LIKE '%$search_query%' OR products LIKE '%$search_query%' OR total LIKE '%$search_query%' OR status LIKE '%$search_query%'";
}
$orders_result = $conn->query($orders_sql);

$suppliers_sql = "SELECT * FROM suppliers $supplier_filter";
if ($search_query) {
    $suppliers_sql = "SELECT * FROM suppliers WHERE name LIKE '%$search_query%' OR phone LIKE '%$search_query%' OR email LIKE '%$search_query%' OR address LIKE '%$search_query%'";
}
$suppliers_result = $conn->query($suppliers_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск по заказам</title>
    <link rel="stylesheet" href="orders.css">
</head>
<body>
    <div class="data-container">
        <h1>Поиск</h1>
        <form method="POST">
            <label for="search_query">Поисковой запрос:</label>
            <input type="text" name="search_query" id="search_query" value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Поиск</button>
        </form>

        <!-- Фильтры для клиентов -->
        <h2>Клиенты</h2>
        <form method="POST">
            <label for="client_name">Имя клиента:</label>
            <input type="text" name="client_name" id="client_name">
            <button type="submit">Фильтровать</button>
        </form>
        <?php if ($clients_result && $clients_result->num_rows > 0): ?>
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

        <!-- Фильтры для продуктов -->
        <h2>Продукты</h2>
        <form method="POST">
            <label for="product_category">Категория:</label>
            <input type="text" name="product_category" id="product_category">
            <button type="submit">Фильтровать</button>
        </form>
        <?php if ($products_result && $products_result->num_rows > 0): ?>
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

        <!-- Фильтры для заказов -->
        <h2>Заказы</h2>
        <form method="POST">
            <label for="order_status">Статус заказа:</label>
            <input type="text" name="order_status" id="order_status">
            <button type="submit">Фильтровать</button>
        </form>
        <?php if ($orders_result && $orders_result->num_rows > 0): ?>
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

        <!-- Фильтры для поставщиков -->
        <h2>Поставщики</h2>
        <form method="POST">
            <label for="supplier_name">Имя поставщика:</label>
            <input type="text" name="supplier_name" id="supplier_name">
            <button type="submit">Фильтровать</button>
        </form>
        <?php if ($suppliers_result && $suppliers_result->num_rows > 0): ?>
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
