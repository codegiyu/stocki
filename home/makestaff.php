<?php
session_start();
include("../includes/connect.php");
$email = $_GET['email'];
try{
    $stmt = $conn->prepare("UPDATE staff SET role =:role WHERE email =:email");
    $stmt->execute(['role'=>'Staff', 'email'=>$email]);
    $_SESSION['success'] = 'Staff role changed to Staff!';
      header('location:viewstaff.php');
}catch(PDOException $e){
    $_SESSION['error'] = $e->getMessage();
    header('location:viewstaff.php');
}
?>

 