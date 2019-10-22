<?php
session_start();
include("../includes/connect.php");
if(!$_SESSION['email']){
    $_SESSION['error'] = 'You must login to access this page!';
    header("location:../login.php");
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
    <title>Edit Items</title>
    <link rel="stylesheet" type="text/css" href="css/itemsstyle.css">
</head>
<body>
    <header>
        <?php include("header.php") ?>
    </header>
</body>
</html>