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
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/indexstyle.css">
</head>
<body>
    <header>
        <?php include("header.php") ?>
    </header>
    <section>
        <div class="container">
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
            <div id="main">
                <div id="mainheader">
    
                </div>
                <div id="mainchart">

                </div>
                <!-- <div id="mainbottom">
                </div> -->
                <div class="headers">
                    <div id="header1">

                    </div>
                    <div id="chart1">

                    </div>
                    <!-- <div id="bottom1">
                    </div> -->
                </div>
                <div class="headers right">
                    <div id="header2">

                    </div>
                    <div id="chart2">

                    </div>
                    <!-- <div id="bottom2">
                    </div> -->
                </div>
                <div class="headers">
                    <div id="header3">

                    </div>
                    <div id="chart3">

                    </div>
                    <!-- <div id="bottom3">
                    </div> -->
                </div>
                <div class="headers right">
                    <div id="header4">

                    </div>
                    <div id="chart4">

                    </div>
                    <!-- <div id="bottom4">
                    </div> -->
                </div>
            </div>
            <div id="aside">
                <div id="aside-top">
                    <p id="list"><b>LISTS</b></p>
                </div>
                <div id='aside-main'>
                
                </div>
            </div>
        </div>
    </section>
    <footer><h5>Copyright stocki© 2019</h5></footer>
</body>
</html>