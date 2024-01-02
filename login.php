<?php
$error_message = ''; // Initialize the error message

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
            echo "Login successful!";
            // Redirect to the dashboard or another page on successful login
            header("Location: home.html");
            exit();
        } else {
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
        $error_message = "Username not found. Please register.";
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }

        #login-container {
            max-width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        #signup-link {
            margin-top: 10px;
            color: #008CBA;
            text-decoration: none;
            font-weight: bold;
        }

        #signup-link:hover {
            color: #00678f;
        }
    </style>
</head>
<body>
    <div id="login-container">
        <h2>Login</h2>

        <?php
        // Display error message if it's not empty
        if (!empty($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>

        <form action="server-side-login-script.php" method="post">
            <label for="login-username">Username:</label>
            <input type="text" id="login-username" name="username" required>

            <label for="login-password">Password:</label>
            <input type="password" id="login-password" name="password" required>

            <button type="submit">Login</button>
        </form>
        
    </div>
</body>
</html>
