<?php
session_start();
include("../includes/connect.php");
$email = $_GET['email'];
try{
    $stmt = $conn->prepare("UPDATE staff SET status =:status, employ_status = :employ_status WHERE email =:email");
    $stmt->execute(['status'=>'0', 'employ_status'=>'Discontinued', 'email'=>$email]);
    $_SESSION['success'] = 'Staff deleted';
    header('location:viewstaff.php');
}catch(PDOException $e){
    $_SESSION['error'] = $e->getMessage();
    header('location:viewstaff.php');
}
?>