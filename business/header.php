<?php
include("../includes/connect.php");
$email = $_SESSION['email'];

$right = $conn->prepare("SELECT staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
$right->execute(['email'=>$email]);
$fetch = $right->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="../css/headerstyle.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="st">
                <a id="stocki" href="../index.php"><b><font color="mediumturquoise">s</font>tocki</b></a>
            </div>
            <div class="left">
                <ul>
                    <li>
                        <a class="links" href="../index.php">HOME</a>
                    </li>
                    <li class="dropdown">
                        <div class="header-links">
                            <a class="links" href="../business.php">BUSINESS</a>
                        </div>
                        <div class="dropdown-con" id="down">
                            <a class="black" href="../business/stock.php">&squf; STOCK</a>
                            <a class="black" href="../business/supplies.php">&squf; SUPPLIES</a>
                            <a class="black" href="../business/sales.php">&squf; SALES</a>
                            <a class="black" href="../business/finances.php">&squf; FINANCES</a>
                            <a class="black" href="../business/balance.php">&squf; BALANCE</a>
                            <a class="black" href="../business/catalogue.php">&squf; CATALOGUE</a>
                            <a class="black" href="../business/edititems.php">&squf; EDIT ITEMS</a>
                            <a class="black" href="../business/extras.php">&squf; EXTRAS</a>
                        </div>
                    </li>
                    <li>
                        <a class="links" href="../analytics.php">ANALYTICS</a>
                    </li>
                    <li>
                        <a class="links" href="../help.php">HELP</a>
                    </li>
                </ul>
            </div>
            <div class="right">
                <div class="dropdown">
                    <button type="button" class="dropbtn">
                        <img id="avatar" style="width:35px; height:35px" src="../img/<?php echo $fetch['photo'] ?>">
                    </button>
                    <div class="dropdown-con" id="myDropdown">
                        <a href="../home/profile.php"><?php echo $fetch['staffname'] ?></a>
                        <a href="../home/updateprofile.php">Update Profile</a>
                        <?php if($fetch['role'] == 'Admin'){ ?>
                        <a href="../home/viewstaff.php">View Staff &#128274;</a>
                        <?php } ?>
                        <a href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>