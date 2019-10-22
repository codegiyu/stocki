<?php
session_start();
include('../includes/connect.php');

if(isset($_POST['changeposition'])){
    $email = $_POST['email'];
    $newposition = $_POST['newposition'];

    try{
        $stmt = $conn->prepare("UPDATE staff SET position = :position WHERE email = :email");
        $stmt = $stmt->execute(['position'=>$newposition, 'email'=>$email]);

        $_SESSION['success'] = 'Position Updated!';
        header('location:viewstaff.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:viewstaff.php');
    }
}
?>