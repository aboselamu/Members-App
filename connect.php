<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_form";

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$filenumber = $_POST['filenumber'];
$email = $_POST['email'];
$phonenumber = $_POST['phonenumber'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$ftype = $_POST['ftype'];

// Database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection Field : ' . $conn->connect_error);
}

// Check if the user already exists
$check_query = "SELECT * FROM registration WHERE phonenumber = '$phonenumber'";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    // User already exists, show an error message
    header("Location: registration-success.php?success=false&message=User already exists. Please choose a different phone number.");
    exit();
}

// Insert new user into the database
$stmt = $conn->prepare("INSERT INTO registration (firstname, lastname, filenumber, email, phonenumber, address, gender, ftype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssisss", $firstname, $lastname, $filenumber, $email, $phonenumber, $address, $gender, $ftype);
$stmt->execute();

// After successful registration
header("Location: registration-success.php?success=true");
exit();

$stmt->close();
$conn->close();
?>
