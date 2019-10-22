<?php
session_start();
include("../includes/connect.php");
$email = $_GET['email'];
try{
    $stmt = $conn->prepare("UPDATE staff SET status =:status WHERE email =:email");
    $stmt->execute(['status'=>'1', 'email'=>$email]);
    $_SESSION['success'] = 'Account Activated!';
      header('location:viewstaff.php');
}catch(PDOException $e){
    $_SESSION['error'] = $e->getMessage();
    header('location:viewstaff.php');
}
?>

 