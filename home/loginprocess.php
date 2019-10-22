<?php
session_start();
include("../includes/connect.php");
if(isset($_POST['login'])){ 
    $email = $_POST['email'];
    $password = $_POST['password'];
    try{
        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM staff WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch();
        if($row['numrows'] > 0){
            if($row['status']){
                if($password == $row['password']){
                    $_SESSION['staffID'] = $row['staffID'];
                    $_SESSION['email'] = $row['email'];
                    header("location:../index.php");
                }
                else{
                    $_SESSION['error'] = 'Incorrect Password!';
                    header("location:../login.php");
                }
            }
            else{


                $_SESSION['error'] = 'Account not activated!';
                header("location:../login.php");
            }
        }
        else{
            $_SESSION['error'] = 'Email not found!';
            header("location:../login.php");
        }
    }catch(PDOException $e){
        echo "There is some problem in connection" . $e->getMessage();
        header("location:../login.php");
    }
}
else{
    $_SESSION['error'] = 'Input login credentials first';
    header("location:../login.php");
}
?>