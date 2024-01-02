<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background-color: #f0f0f0;
        }

        .message {
            max-width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            margin-bottom: 20px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .button-container {
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .go-back {
            background-color: #4CAF50;
            color: white;
        }

        .register-again {
            background-color: #008CBA;
            color: white;
        }
    </style>
</head>
<body>

<div class="message">
    <?php
    // Check if success parameter is true and display the appropriate message
    if (isset($_GET['success'])) {
        if ($_GET['success'] == 'true') {
            echo '<p class="success">' . ($_GET['message'] ?? 'Registration successful!') . '</p>';
        } else {
            echo '<p class="error">' . ($_GET['message'] ?? 'An error occurred.') . '</p>';
        }
    } else {
        echo '<p class="error">Invalid access. Please try again.</p>';
    }
    ?>
</div>

<div class="button-container">
    <a href="javascript:history.back()" class="button go-back">Back</a>
    <a href="display.php" class="button register-again">Check Entry</a>
</div>

</body>
</html>
