<?php
session_start();
include("../includes/connect.php");
if(isset($_POST['register'])){
    $staffname = $_POST['staffname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $photo = "img/user.jpg";
    $role = 'Staff';
    $status = 1;
       
    $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM staff WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $rows = $stmt->fetch();
    if($rows['numrows'] > 0){
        $_SESSION['error'] = 'Email already exists!';
        header('location:../register.php');
    }
    else
    if($password != $cpassword){
        $_SESSION['error'] = 'Passwords do not match!';
        header('location:../register.php');
    }else  
    try{
        $stmt = $conn->prepare("INSERT INTO staff (email, password, role, status) VALUES (:email, :password, :role, :status)");
        $stmt->execute(['email'=>$email, 'password'=>$password, 'role'=>$role, 'status'=>$status]);

        $stmt = $conn->prepare("INSERT INTO staffprofile (staffID, staffname, photo) VALUES ((SELECT staffID FROM staff WHERE email = '$email'), :staffname, :photo)");
        $stmt->execute(['staffname'=>$staffname, 'photo'=>$photo]);

        $stmt = $conn->prepare("INSERT INTO staffaddress (staffID) VALUE ((SELECT staffID FROM staff WHERE email = '$email'))");
        $stmt->execute();
        $_SESSION['success'] = "Acccount Created Successfully. Please login!";
        header('location:../login.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:../register.php');
    }
}
?>