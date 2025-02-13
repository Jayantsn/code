<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = ""; // Default for XAMPP
$database = "signupDB";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $countryCode = isset($_POST['countryCode']) ? trim($_POST['countryCode']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate if fields are empty
    if (empty($email) || empty($phone) || empty($password)) {
        die("Error: All fields are required.");
    }

    // Check if email is Gmail (restriction)
    if (strpos($email, "@gmail.com") !== false) {
        die("Error: Signing up with Gmail is not permitted.");
    }

    // Concatenate full phone number
    $fullPhone = $countryCode . $phone;

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (email, phone, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $fullPhone, $hashedPassword);

    // Execute the query
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
s