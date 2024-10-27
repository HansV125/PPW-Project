<?php
session_start();
$host = 'localhost';
$dbname = 'projectppw';
$username = 'root';  // Update with your DB username
$password = '';      // Update with your DB password

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $captcha = $_POST["captcha"];

        // Verify CAPTCHA
        if ($captcha != $_SESSION["captcha"]) {
            echo "<p style='color:red;'>Incorrect CAPTCHA. Please try again.</p>";
            exit();
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hashed_password,
        ]);

        echo "<p style='color:green;'>Registration successful! You can now log in.</p>";
    }
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        // Error code 23000 is for duplicate entries
        echo "<p style='color:red;'>This email is already registered. Please use another email.</p>";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
