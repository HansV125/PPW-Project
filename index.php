<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Our Store</h1>
    <div class="product-container">
        <?php
        include 'db.php';

        // Fetch products from the database
        $stmt = $pdo->query("SELECT id, name, price, image FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display products
        foreach ($products as $product) {
            echo '<div class="product">';
            echo '<img src="' . $product['image'] . '" alt="' . $product['name'] . '">';
            echo '<h2>' . htmlspecialchars($product['name']) . '</h2>';
            echo '<p>$' . number_format($product['price'], 2) . '</p>';
            echo '<a href="product.php?id=' . $product['id'] . '" class="view-details">View Details</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
