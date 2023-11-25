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

        <div id="signupForm">
            <h2>Sign Up</h2>
            <form id="signup" action="" method="post">
                <div class="form-group">
                    <label for="signupUsername">Username / Email:</label>
                    <input type="text" class="form-control" id="signupUsername" name="signupUsername" required>
                </div>
                <div class="form-group">
                    <label for="signupPassword">Password:</label>
                    <input type="password" class="form-control" id="signupPassword" name="signupPassword" required>
                </div>
                <div class="form-group">
                    <label for="signupPassword">Confirm Password:</label>
                    <input type="password" class="form-control" id="signupPassword" name="signupPassword" required>
                </div>
                <button type="submit" class="btn btn-success">Sign Up</button>
            </form>
        </div>
    </div>

    <?php

    $conn = mysqli_connect("localhost", "root", "", "stock_analysis");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $a = "";
        $b = "";


        if (isset($_POST["signupUsername"]) && isset($_POST["signupPassword"])) {
            $a = mysqli_real_escape_string($conn, $_POST["signupUsername"]);
            $b = mysqli_real_escape_string($conn, $_POST["signupPassword"]);
            $query = "INSERT INTO `users`(`username`, `password`) VALUES ('$a', '$b')";
            $insert = mysqli_query($conn, $query);

            if ($insert) {
                // echo '<script>';
                // echo 'alert("Sign-up successful! Please log in to continue.");';
                // echo 'setTimeout(function() { window.location.href = "login.php"; }, 0);'; 
                // echo '</script>';
                echo '<script>';
                echo 'alert("Sign-up successful! Please log in to continue.");';
                echo 'window.location.href = "login.php";'; // Redirect after showing the alert
                echo '</script>';
            } else {
                echo "Sorry! There is some problem.";
            }
        } else {
            echo "Form fields are not set.";
        }
    }
    ?>

</body>

</html>