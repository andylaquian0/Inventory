<?php 
include_once('dbconnect.php'); 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wings City Login</title>
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

        .login-container {
            background-color: rgba(50, 50, 50, 0.9); /* Darker transparent background */
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); /* Darker box shadow */
            padding: 40px;
            text-align: center;
            width: 400px;
            transition: transform 0.3s;
            border: 2px solid #FEA116; /* Updated border color */
        }

        .login-container:hover {
            transform: scale(1.02);
        }

        .login-container img {
            height: 100px; /* Adjust height as needed */
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #FEA116; /* Updated heading color */
        }

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
    <div class="login-container">
        <img src="img/1.png" alt="Logo">
        <h2>Admin Login</h2>
        <form action="" method="post">
            <p>Email: <input type="email" name="email" required></p>
            <p>Password: <input type="password" name="pass" required></p>
            <input type="submit" value="Log In" name="log">
            <p><a href="passcode.php">Create an account</a></p>
        </form>

        <?php
        if (isset($_POST['log'])) {
            $email = $_POST['email'];
            $password = $_POST['pass'];

            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $user = mysqli_fetch_assoc($result);

                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id']; 
                        $_SESSION['role'] = $user['role']; 
                        header("Location: inventory.php");
                        exit();
                    } else {
                        echo "<script>alert('Incorrect password.');</script>";
                    }
                } else {
                    echo "<script>alert('Email not found.');</script>";
                }
            } else {
                echo "<script>alert('Query error.');</script>";
            }
        }
        ?>
    </div>
</body>
</html>
