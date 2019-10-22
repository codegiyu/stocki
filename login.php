<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/loginstyle.css">
</head>
<body>
    <form id="box" method="POST" action="home/loginprocess.php">
        <h1 class="container"><font id="s">s</font>tocki</h1>
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
            <label><h4><b>Email</b></h4></label>
            <input type="email" name="email" class="inputgroup" placeholder="Email" required>
            <label><h4><b>Password</b></h4></label>
            <input type="password" name="password" class="inputgroup" placeholder="Password" required>
            <button type="submit" name="login">Log in</button>
            <p id="link"><a href="register.php">Don't have an account?</a></p>
        </ul>
        <p id="down">Powered by stocki</p>
    </form>
</body>
</html>