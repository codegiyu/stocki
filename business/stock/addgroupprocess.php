<?php
session_start();
include("../../includes/connect.php");
if(isset($_POST['addgroup'])){
    $groupname = $_POST['groupname'];

    $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM groups WHERE groupname = :groupname");
    $stmt->execute(['groupname'=>$groupname]);
    $rows = $stmt->fetch();
    if($rows['numrows'] > 0){
        $_SESSION['error'] = 'This group already exists!';
        header('location:../stock.php');
    }else  
    try{
        $stmt = $conn->prepare("INSERT INTO groups (groupname) VALUES (:groupname)");
        $stmt->execute(['groupname'=>$groupname]);
        $_SESSION['success'] = "Group Added Successfully!";
        header('location:../stock.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:../stock.php');
    }
}
?>