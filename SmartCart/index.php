<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login3.css">
</head>
<body>
<div class="login-background">
    </div>
        <div class="container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="vertical-center">
                <h1 class="welcome-message">Login</h1>
        <h2 class="welcome-message">Welcome to SmartCart</h2>
    </div>
                <?php if(isset($error)) { ?>
                    <p class="error-message"><?php echo $error;?></p>
                <?php } ?>
                <div class="input-box">
                    <input type="text" name="ID" placeholder="ID" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
              
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Establish database connection
$conn = new mysqli("localhost", "root", "", "Smartcart");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error variable
$error = "";

// Check if the form is submitted
if(isset($_POST["login"])) {
    $id=$_POST["ID"];
    $password = $_POST["password"];
  
    // Sanitize inputs
    $ID = sanitizeInput($ID);
    $password = sanitizeInput($password);

    // Construct SQL query to check if user exists and password matches
    $sql = "SELECT * FROM User WHERE ID = '$id' AND password='$password'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"]; // Assuming user_id is the primary key of the User2 table
        // Redirect the user to the appropriate page based on user role
        if ($row["IsAdmin"] == 0) {
            // echo  $_SESSION["user_id"];
            // User is not an admin, redirect to home page
             header("Location:homePage.php");
            exit();
        } elseif ($row["IsAdmin"] == 1) {
            // User is an admin, redirect to admin page
            header("Location: uploadImage.php");
            exit();
        }
    } else {
        // Email or password is incorrect
        $error = "Invalid email or password";
    }
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
