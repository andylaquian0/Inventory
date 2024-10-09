<?php
include_once('dbconnect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $query = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $insertQuery = "INSERT INTO users (email, password, firstname, lastname) 
                        VALUES (?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "ssss", $email, $password, $firstname, $lastname);
        
        if (mysqli_stmt_execute($insertStmt)) {
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            header("Location: login.php");
            exit();
        } else {
            $errorMsg = "Error: " . mysqli_error($conn);
        }
    } else {
        $errorMsg = "This email is already registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            background-color: #2c2c2c; /* Dark background color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: #fff; /* White text for better contrast */
        }

        .registration-container {
            background-color: rgba(50, 50, 50, 0.9); /* Darker transparent background */
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); /* Darker box shadow */
            padding: 40px;
            text-align: center;
            width: 400px;
            border: 2px solid #FEA116; /* Updated border color */
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #FEA116; /* Updated gold color for headings */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #FEA116; /* Updated border color for inputs */
            border-radius: 5px;
            font-size: 16px;
            color: #fff; /* White text for inputs */
            background-color: #444; /* Dark background for inputs */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Box shadow for input fields */
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #FFD700; /* Gold color on focus */
            outline: none;
            box-shadow: 0 0 5px rgba(255, 215, 0, 0.5); /* Focus shadow for input fields */
        }

        input[type="submit"] {
            background-color: #FEA116; /* Updated background color */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Box shadow for button */
        }

        input[type="submit"]:hover {
            background-color: #d69a13; /* Darker shade on hover */
            transform: translateY(-2px);
        }

        .error-message {
            color: #FF4500; /* Red color for error messages */
            margin-top: 10px;
        }

        p {
            margin: 10px 0;
            color: #FEA116; /* Updated color for paragraph text */
        }

        a {
            color: #FEA116; /* Updated color for links */
            text-decoration: none;
            transition: color 0.3s;
        }

        a:hover {
            text-decoration: underline;
            color: #FFC300; /* Slightly lighter shade on hover */
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <img src="img/1.png" alt="Logo" height="150px">
        <h2>Create Your Account</h2>
        <form action="register.php" method="POST" class="registration-form">
            <input type="text" name="firstname" placeholder="First Name" required><br>
            <input type="text" name="lastname" placeholder="Last Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Sign Up">
        </form>
        <?php if (isset($errorMsg)) { echo "<p class='error-message'>$errorMsg</p>"; } ?>
        
        <p>Already a member? <a href="login.php">Log in here</a></p>
    </div>
</body>
</html>
