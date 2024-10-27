<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    include 'db.php';

    if (isset($_GET['id'])) {
        $productId = (int) $_GET['id'];

        // Prepare SQL to fetch product details
        $stmt = $pdo->prepare("SELECT name, price, description, image FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo '<div class="product-details">';
            echo '<img src="' . $product['image'] . '" alt="' . htmlspecialchars($product['name']) . '">';
            echo '<h1>' . htmlspecialchars($product['name']) . '</h1>';
            echo '<p>Price: $' . number_format($product['price'], 2) . '</p>';
            echo '<p>Description: ' . htmlspecialchars($product['description']) . '</p>';
            echo '<button>Add to Cart</button>';
            echo '</div>';
        } else {
            echo '<p>Product not found.</p>';
        }
    } else {
        echo '<p>Product ID is missing.</p>';
    }
    ?>
</body>
</html>
