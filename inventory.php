<?php 
include_once('dbconnect.php'); 
session_start();

// Logout functionality
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Search functionality
$search_results = [];
$sort_order = 'ASC'; // Default sort order
$sort_column = 'item_name'; // Default sort column

if (isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);
    $sql = "SELECT * FROM inventory WHERE item_name LIKE '%$search_term%'";
    $search_results = mysqli_query($conn, $sql);
}

// Handle sorting
if (isset($_POST['sort'])) {
    $sort_column = $_POST['sort_column'];
    $sort_order = $_POST['sort_order'];
}

// Add stock functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_stock'])) {
        $item_name = $_POST['item_name'];
        $amount = $_POST['amount'];
        $expiration_date = $_POST['expiration_date'];
        $category = $_POST['category'];
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["item_image"]["name"]);
        $upload_ok = 1;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["item_image"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.');</script>";
            $upload_ok = 0;
        }

        if ($_FILES["item_image"]["size"] > 2000000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            $upload_ok = 0;
        }

        if (!in_array($image_file_type, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            $upload_ok = 0;
        }

        if ($upload_ok == 0) {
            echo "<script>alert('Sorry, your file was not uploaded.');</script>";
        } else {
            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO inventory (item_name, amount, expiration_date, category, image_url) 
                        VALUES ('$item_name', '$amount', '$expiration_date', '$category', '$target_file')";
                mysqli_query($conn, $sql);
                echo "<script>alert('Stock added successfully!');</script>";
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    }

    // Update stock functionality
    if (isset($_POST['update_stock'])) {
        $item_id = $_POST['item_id'];
        $updated_amount = $_POST['updated_amount'];
        $sql = "UPDATE inventory SET amount = amount + $updated_amount WHERE id = $item_id";
        mysqli_query($conn, $sql);
        echo "<script>alert('Stock updated successfully!');</script>";
    }

    // Use stock functionality
    if (isset($_POST['use_stock'])) {
        $item_id = $_POST['item_id'];
        $used_amount = $_POST['used_amount'];
        $sql = "UPDATE inventory SET amount = amount - $used_amount WHERE id = $item_id";
        mysqli_query($conn, $sql);
        echo "<script>alert('Stock used successfully!');</script>";
    }
}

// Function to display inventory
function displayInventory($category, $conn, $search_results = null, $sort_column = 'item_name', $sort_order = 'ASC') {
    if ($search_results) {
        $result = $search_results;
    } else {
        $sql = "SELECT * FROM inventory WHERE category='$category' ORDER BY $sort_column $sort_order";
        $result = mysqli_query($conn, $sql);
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='inventory-container'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='inventory-item'>
                    <img src='{$row['image_url']}' alt='{$row['item_name']}' class='inventory-image'>
                    <h3>{$row['item_name']}</h3>
                    <p>Amount: {$row['amount']}</p>
                    <p>Expiration Date: {$row['expiration_date']}</p>
                    <form method='POST' action=''>
                        <input type='hidden' name='item_id' value='{$row['id']}'>
                        <input type='number' name='updated_amount' placeholder='Add amount' required>
                        <button type='submit' name='update_stock'>Update</button>
                    </form>
                    <form method='POST' action=''>
                        <input type='hidden' name='item_id' value='{$row['id']}'>
                        <input type='number' name='used_amount' placeholder='Use amount' required>
                        <button type='submit' name='use_stock' class='use-button'>Use</button>
                    </form>
                </div>";
        }
        echo "</div>";
    } else {
        echo "<p>No items in $category.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WINGS CITY INVENTORY</title>
    <link rel="stylesheet" href="stylesinventory.css">
    <style>
        body {
            background-color: #2c3e50; /* Dark background color */
            color: #ecf0f1; /* Light text color */
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #34495e; /* Darker navigation background */
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav img {
            height: 50px; /* Logo size */
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 15px;
        }

        nav a {
            color: #ecf0f1; /* Link color */
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

    

        .search-form {
            display: flex;
            align-items: center;
          ;
         
        }

        .search-form input {
            padding: 8px;
            border: 1px solid #FEA116;
            border-radius: 5px;
            margin-right: 10px;
            background-color: #34495e; /* Input background */
            color: #ecf0f1; /* Input text color */
        }

        .search-form button {
            background-color: #FEA116;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: #d69a13; /* Button hover effect */
        }

        .content {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background-color: rgba(44, 62, 80, 0.8); /* Transparent dark background */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            color: #FEA116; /* Title color */
        }

        h2 {
            border-bottom: 2px solid #FEA116; /* Underline for section headers */
            padding-bottom: 10px;
            color: #FEA116; /* Updated section header color */
        }

        .sort-dropdown {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .sort-dropdown select,
        .sort-dropdown button {
            padding: 8px;
            margin-left: 10px;
            border: 1px solid #FEA116;
            border-radius: 5px;
            background-color: #34495e; /* Input background */
            color: #ecf0f1; /* Input text color */
        }

        .add-stock-form input,
        .add-stock-form select,
        .add-stock-form button {
            width: calc(100% - 20px); /* Make inputs full width minus padding */
            max-width: 800px; /* Set a maximum width for better appearance */
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #FEA116; /* Updated border color */
            border-radius: 5px;
            background-color: #34495e; /* Input background */
            color: #ecf0f1; /* Input text color */
        }

        .add-stock-form button {
            background-color: #FEA116; /* Updated button color */
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 600px;
            margin-left: 100px;
           
        }

        .add-stock-form button:hover {
            background-color: green; /* Button hover effect */
        }

        .inventory-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .inventory-item {
            background-color: #34495e; /* Item background color */
            border-radius: 10px;
            padding: 15px;
            flex: 1 1 30%; /* Responsive item width */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .inventory-image {
            max-width: 100%;
            border-radius: 5px;
        }

        .inventory-item h3 {
            color: #FEA116; /* Item name color */
        }

        .inventory-item form {
            margin-top: 10px;
        }

        .inventory-item input {
            width: auto; /* Allow input fields to not take full width */
            margin-right: 5px;
            border: 2.5px solid #FEA116;
            height: 30px;
        }

        .inventory-item button {
            background-color: #3498db; /* Blue background for the buttons */
            color: white; /* White text */
            border: none; /* Remove default border */
            padding: 10px 15px; /* Add padding */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s, transform 0.3s; /* Smooth transition for hover effects */
            font-size: 14px; /* Font size */
        }

        .inventory-item button:hover {
            background-color: #2980b9; /* Darker blue on hover */
            transform: scale(1.05); /* Slightly grow on hover */
        }

        .inventory-item .use-button {
            background-color: #e74c3c; /* Red background for the Use button */
        }

        .inventory-item .use-button:hover {
            background-color: #c0392b; /* Darker red on hover */
        }

        .pic {
            height: 80px;
        }
        .a{
            display: flex;
            flex-direction: row;
           justify-content: space-between;
        }
        .logout-button {
        background-color:red; /* Red background for the logout button */
        color: white; /* White text */
        border: none; /* Remove default border */
        padding: 10px 15px; /* Add padding */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        font-size: 14px; /* Font size */
        margin-left: auto; /* Push it to the right */
        text-decoration: none;
        transition: 0.1s;
        font-size: 15px;
        }
        .logout-button:hover{
            background-color: darkred;
            transition: 0.1s;
        }
        .sort-dropdown button {
        background-color: #FEA116; /* Button color */
        color: white; /* Text color */
        border: none; /* Remove default border */
        padding: 10px 15px; /* Add padding */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        transition: background-color 0.3s, transform 0.3s; /* Smooth transition for hover effects */
        font-size: 14px; /* Font size */
}

        .sort-dropdown button:hover {
            background-color: #d69a13; /* Darker button color on hover */
            transform: scale(1.05); /* Slightly grow on hover */
        }


    </style>
</head>
<body>
    <nav>
        <img src="img/1.png" class="pic">
      
        <ul>
            <li>
            <form method="GET" action="index.html" style="margin: 0;">
           <input type="hidden" name="action" value="logout">
            <button type="submit" class="logout-button"><a href="index.html?action=logout">Logout</a></button>
            </form>
            </li>
            
            <?php if (isset($_SESSION['user_id'])) { ?>
                <?php if ($_SESSION['role'] === 'manager') { ?>
                    <li><a href="add_food.php">Add New Food</a></li>
                    <li><a href="index.php">View Menu</a></li>
                    <li><a href="inventory.php">Manage Inventory</a></li>
                    <li class="dropdown">
                        <a href="#">Inventory ▼</a>
                        <div class="dropdown-content">
                            <a href="#freezer">Freezer</a>
                            <a href="#chiller">Chiller</a>
                            <a href="#stockroom">Stockroom</a>
                        </div>
                    </li>
                <?php } ?>
               
            <?php } else { ?>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
    </nav>

    <div class="content">
        <div class="a">
        <h1>WINGS CITY INVENTORY</h1>
        <form method="POST" class="search-form">
                    <input type="text" name="search_term" placeholder="Search items..." required>
                    <button type="submit" name="search">Search</button>
                </form>
       
        </div>
        
        <h2>Add Stock</h2>
        <form method="POST" action="" class="add-stock-form" enctype="multipart/form-data">
            <input type="text" name="item_name" placeholder="Item Name" required>
            <input type="number" name="amount" placeholder="Amount" required>
            <input type="date" name="expiration_date" required>
            <input type="file" name="item_image" accept="image/*" required>
            <select name="category" required>
                <option value="Freezer">Freezer</option>
                <option value="Chiller">Chiller</option>
                <option value="Stockroom">Stockroom</option>
            </select>
            <button type="submit" name="add_stock">Add Stock</button>
        </form>

        <h2 id="freezer">Freezer</h2>
        <div class="sort-dropdown">
            <form method="POST" action="">
                <select name="sort_order">
                    <option value="ASC">Sort by Name (Ascending)</option>
                    <option value="DESC">Sort by Name (Descending)</option>
                </select>
                <input type="hidden" name="sort_column" value="item_name">
                <button type="submit" name="sort">Sort</button>
            </form>
        </div>
        <?php displayInventory('Freezer', $conn, $search_results, $sort_column, $sort_order); ?>

        <h2 id="chiller">Chiller</h2>
        <div class="sort-dropdown">
            <form method="POST" action="">
                <select name="sort_order">
                    <option value="ASC">Sort by Name (Ascending)</option>
                    <option value="DESC">Sort by Name (Descending)</option>
                </select>
                <input type="hidden" name="sort_column" value="item_name">
                <button type="submit" name="sort">Sort</button>
            </form>
        </div>
        <?php displayInventory('Chiller', $conn, $search_results, $sort_column, $sort_order); ?>

        <h2 id="stockroom">Stockroom</h2>
        <div class="sort-dropdown">
            <form method="POST" action="">
                <select name="sort_order">
                    <option value="ASC">Sort by Name (Ascending)</option>
                    <option value="DESC">Sort by Name (Descending)</option>
                </select>
                <input type="hidden" name="sort_column" value="item_name">
                <button type="submit" name="sort">Sort</button>
            </form>
        </div>
        <?php displayInventory('Stockroom', $conn, $search_results, $sort_column, $sort_order); ?>
    </div>
</body>
</html>
