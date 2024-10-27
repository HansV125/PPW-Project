<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "projectppw"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_path = "uploads/" . basename($_FILES['image']['name']);
        
        // Check if the 'uploads' directory exists, if not, create it
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            // Insert product into database
            $stmt = $conn->prepare("INSERT INTO products (name, price, description, image, category, stock) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sdsssi", $name, $price, $description, $image_path, $category, $stock);
            
            if ($stmt->execute()) {
                echo "<p>Product added successfully!</p>";
            } else {
                echo "<p>Error adding product: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Error uploading image.</p>";
        }
    } else {
        echo "<p>Please upload a valid image.</p>";
    }
}

$conn->close();
?>
