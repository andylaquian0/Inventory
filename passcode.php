<?php
session_start();

$validPasscode = "carlivan"; // Set your passcode here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['passcode'] !== $validPasscode) {
        die("Invalid passcode.");
    }

    // Redirect to the registration page
    header("Location: register.php"); // Replace with your actual registration page URL
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Passcode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        .container {
            background-color: rgba(50, 50, 50, 0.9); /* Darker transparent background */
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); /* Darker box shadow */
            padding: 40px;
            text-align: center;
            width: 400px;
            transition: transform 0.3s;
            border: 2px solid #FEA116; /* Updated border color */
        }

        .container:hover {
            transform: scale(1.02);
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #FEA116; /* Updated heading color */
        }

        img {
            height: 100px; /* Adjust height as needed */
            margin-bottom: 20px;
        }

        input[type="password"] {
            width: 380px;
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

        input[type="password"]:focus {
            border-color: #FFD700; /* Gold color on focus */
            outline: none;
            box-shadow: 0 0 5px rgba(255, 215, 0, 0.5); /* Focus shadow for input fields */
        }

        button {
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

        button:hover {
            background-color: #d69a13; /* Darker shade on hover */
            transform: translateY(-2px);
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="img/1.png" alt="Logo"> <!-- Update the path to your logo -->
        <h2>Admin Permission Code</h2>
        <div id="errorMessage" class="error hidden"></div>
        <form method="post" id="mainForm">
            <input type="password" name="passcode" id="passcode" placeholder="Enter Passcode" required />
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        const validPasscode = "carlivan"; // Set your passcode here

        document.getElementById('mainForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent the form from submitting

            const inputPasscode = document.getElementById('passcode').value;
            const errorMessage = document.getElementById('errorMessage');

            if (inputPasscode === validPasscode) {
                // If the passcode is correct, submit the form
                this.submit();
            } else {
                errorMessage.textContent = "Invalid passcode. Please try again.";
                errorMessage.classList.remove('hidden');
            }
        };
    </script>
</body>

</html>
