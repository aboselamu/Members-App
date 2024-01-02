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

    // Check if the username already exists
    $check_query = "SELECT * FROM employees WHERE username='$username'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Insert the new user into the database
        $insert_query = "INSERT INTO employees (username, password) VALUES ('$username', '$password')";
        if ($conn->query($insert_query) === TRUE) {
            echo "Registration successful! You can now login.";
            
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
