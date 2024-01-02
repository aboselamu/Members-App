<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dev360_employes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Check if the username exists
    $check_query = "SELECT * FROM employees WHERE username='$username'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the password
        if ($password == $hashed_password) {
            // Redirect to the dashboard upon successful login
            header("Location: home.html");
            exit();
        } else {
            // Redirect back to the login page with an error message
            header("Location: login.php?error=IncorrectPassword");
            exit();
        }
    } else {
        // Redirect back to the login page with an error message
        header("Location: login.php?error=UsernameNotFound");
        exit();
    }
}

// Close the database connection
$conn->close();
?>
