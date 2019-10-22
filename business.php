<?php
session_start();
include("includes/connect.php");
if(!$_SESSION['email']){
    $_SESSION['error'] = 'You must login to access this page!';
    header("location:login.php");
}

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT * FROM staffprofile JOIN staff ON staffprofile.staffID = staff.staffID");
$stmt->execute(['email'=>$email]);

$right = $conn->prepare("SELECT staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
$right->execute(['email'=>$email]);
$fetch = $right->fetch();

$stmt = $conn->prepare("SELECT staff.staffID AS staffID, staff.email AS email, staff.position AS position, staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo, staffprofile.phone AS phone, staffprofile.gender AS gender, staffprofile.dob AS dob, staffprofile.originstate AS originstate, staffprofile.lga AS lga, staffprofile.hometown AS hometown, staffprofile.maritalstatus AS maritalstatus, staffaddress.address AS address, staffaddress.area AS area, staffaddress.city AS city, staffaddress.addressstate AS addressstate FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID JOIN staffaddress ON staff.staffID = staffaddress.staffID WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Business</title>
    <link rel="stylesheet" type="text/css" href="css/businessstyle.css">
    <script src="js/shop.js"></script>
</head>
<body>
    <header>
        <?php include("header.php") ?>
    </header>
    <section id="top">
        <h2 class="container"><font color="#731D64" size="6">MY BUSINESS</font><font color="gray" size="6"></h2>
    </section>
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
    <div class="container1">
        <table width="100%">
            <col style="width:33.3%">
            <col style="width:33.3%">
            <col style="width:33.3%">
            <tr>
                <td>
                    <a href="business/stock.php">
                    <div class="box">
                        <h2>Stock</h2>
                        <p>View and manage availaible items &#x0290D;</p>
                    </div>
                    </a>
                </td>
                <td>
                    <a href="business/sales.php">
                        <div class="box">
                            <h2>Sales</h2>
                            <p>View and manage sales &#x0290D;</p>
                        </div>
                    </a>
                </td>
                <td>
                    <a href="business/supplies.php">
                        <div class="box">
                            <h2>Supply</h2>
                            <p>View and manage supplies &#x0290D;</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="business/finances.php">
                        <div class="box">
                            <h2>Finances</h2>
                            <p>View and manage transactions &#x0290D;</p>
                        </div>
                    </a>
                </td>
                <td>
                    <a href="business/catalogue.php">
                        <div class="box">
                            <h2>Catalogue</h2>
                            <p>View all available items &#x0290D;</p>
                        </div>
                    </a>
                </td>
                <td>
                    <a href="business/edititems.php">
                        <div class="box">
                            <h2>Edit Items</h2>
                            <p>Edit items, groups and subgroups &#x0290D;</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="business/extras.php">
                        <div class="box">
                            <h2>Extras</h2>
                            <p>View other lists &#x0290D;</p>
                        </div>
                    </a>
                </td>
                <td>
                    <?php if($fetch['role'] == 'Admin'){ ?>
                        <a href="business/balance.php">
                            <div class="box">
                                <h2>Balance &#128274;</h2>
                                <p>View available shop balance &#x0290D;</p>
                            </div>
                        </a>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
    <footer><h5>Copyright stocki© 2019</h5></footer>
</body>
</html>