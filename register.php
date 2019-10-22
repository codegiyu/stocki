<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/registerstyle.css">
</head>
<body>
    <form id="box" method="POST" action="home/processregister.php">
        <h1 class="container"><font color="teal">s</font>tocki</h1>
        <?php
            if(isset ($_SESSION['error'])) {
                echo "
                <div class= 'error'>
                <p>".$_SESSION['error']."</p>
                </div>
                ";
                unset($_SESSION['error']);
            }

            if(isset($_SESSION['success'])){
                echo "
                <div class= 'success'>
                <p>".$_SESSION['success']. "</p>
                </div>
                ";
                unset($_SESSION['success']);
            }
        ?>
        <ul class="container">
            <label><h4>Name</h4></label>
            <input type="text" name="staffname" class="inputgroup" placeholder="Name" required>
            <label><h4><b>Email</b></h4></label>
            <input type="email" name="email" class="inputgroup" placeholder="Email" required>
            <label><h4><b>Password</b></h4></label>
            <input type="password" name="password" class="inputgroup" placeholder="Password" required>
            <label><h4><b>Confirm Password</b></h4></label>
            <input type="password" name="cpassword" class="inputgroup" placeholder="Confirm Password" required>
            <input type="submit" name="register" value="Register">
            <p id="link"><a href="login.php">Already have an account?</a></p>
        </ul>
    </form>
</body>
</html>