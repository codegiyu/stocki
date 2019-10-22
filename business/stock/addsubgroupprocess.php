<?php
session_start();
include("../../includes/connect.php");
if(isset($_POST['addsubgroup'])){
    $groupID = $_POST['groupID'];
    $subgroupname = $_POST['subgroupname'];

    $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM subgroups WHERE subgroupname = :subgroupname && groupID = :groupID");
    $stmt->execute(['subgroupname'=>$subgroupname, 'groupID'=>$groupID]);
    $rows = $stmt->fetch();
    if($rows['numrows'] > 0){
        $_SESSION['error'] = 'This subgroup already exists within this group!';
        header('location:../stock.php');
    }else  
    try{
        $stmt = $conn->prepare("INSERT INTO subgroups (subgroupname, groupID) VALUES (:subgroupname, :groupID)");
        $stmt->execute(['subgroupname'=>$subgroupname, 'groupID'=>$groupID]);
        $_SESSION['success'] = "Subgroup Added Successfully!";
        header('location:../stock.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:../stock.php');
    }
}
?>