<style>
        body {
          
            background-image: url(image.jpg);
            background-repeat:no-repeat;
            background-size:cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
       font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        h2 {
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
<?php
session_start();
session_destroy();
echo "<h2> You are Successfully Logout</h2><br/>";
echo "<a href='Login.php'>Login again</a><br/>";
?>