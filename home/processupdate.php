<?php
session_start();
include('../includes/connect.php');
$email = $_SESSION['email'];

if(isset($_POST['update'])){
    $id = $_GET['email'];
    $staffname = $_POST['staffname'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $maritalstatus = $_POST['maritalstatus'];
    $originstate = $_POST['originstate'];
    $lga = $_POST['lga'];
    $hometown = $_POST['hometown'];
    $address = $_POST['address'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $addressstate = $_POST['addressstate'];
    $stmt = $conn->prepare("SELECT staff.email AS email, staffprofile.staffID AS staffID FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();
    $staffID = $row['staffID'];

    try{
    $stmt = $conn->prepare("UPDATE staffprofile SET staffname = :staffname, phone = :phone, gender = :gender, dob = :dob, maritalstatus = :maritalstatus, originstate = :originstate, lga = :lga, hometown = :hometown WHERE staffID = '$staffID'");
    $stmt = $stmt->execute(['staffname'=>$staffname, 'phone'=>$phone, 'gender'=>$gender, 'dob'=>$dob, 'maritalstatus'=>$maritalstatus, 'originstate'=>$originstate, 'lga'=>$lga, 'hometown'=>$hometown]);

    $stmt = $conn->prepare("UPDATE staffaddress SET address = :address, area = :area, city = :city, addressstate = :addressstate WHERE staffID = '$staffID'");
    $stmt = $stmt->execute(['address'=>$address, 'area'=>$area, 'city'=>$city, 'addressstate'=>$addressstate]);
       
    $_SESSION['success'] = 'Profile Updated!';
        header('location:updateprofile.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:updateprofile.php');
    }
}
?>