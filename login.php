<?php

session_start();
$host = 'localhost';
$username_db = 'root';
$password_db = '';
$database = 'stock_analysis';
$conn = new mysqli($host, $username_db, $password_db, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['submit'])){

   $user = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);

   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE  username = '$user' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['username'] = $row['username'];
      header('location:index.php');
   }else{
    echo '<script>';
    echo'alert("Incorrect username or password")';
    echo '</script>';
   }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Analysis Tool</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url(image.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            padding: 50px;
            color: rgb(0, 0, 0);
            font-size: 28px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="mb-4">Stock Analysis Tool</h1>

        <div id="loginForm">
            <h2>Login</h2>
            <form id="login" method="post">
                <div class="form-group">
                    <label for="loginUsername">Username / Email:</label>
                    <input type="text" class="form-control" id="loginUsername" name="username" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password:</label>
                    <input type="password" class="form-control" id="loginPassword" name="password" required>
                </div>
                <input type="submit" class="btn btn-primary" name="submit">
                <div class="click">Don't Have Account <a href="signup.php">Click Here</a></div>
            </form>
        </div>
    </div>
</body>

</html>