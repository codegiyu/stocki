<?php
session_start();
include("../../includes/connect.php");

if(isset($_POST['additem'])){
    $itemname = $_POST['itemname'];
    $unit = $_POST['unit'];
    $saleprice = $_POST['saleprice'];
    $supplyprice = $_POST['supplyprice'];
    $groupID = $_POST['groupID'];
    $subgroupID = $_POST['subgroupID'];
    $description = $_POST['description'];
    $img = $_FILES['photo']['name'];

    if(!empty($img)){
        $ext = pathinfo($img, PATHINFO_EXTENSION);
        $newImg = 'Updated'.time();
        move_uploaded_file($_FILES['photo']['tmp_name'], '../../img/'.$newImg);	
        }
        else{
            $newImg = '';
    }

    $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM items WHERE itemname = :itemname && subgroupID = :subgroupID && groupID = :groupID");
    $stmt->execute(['itemname'=>$itemname, 'subgroupID'=>$subgroupID, 'groupID'=>$groupID]);
    $rows = $stmt->fetch();
    if($rows['numrows'] > 0){
        $_SESSION['error'] = 'This product already exists!';
        header('location:../stock.php');
    }else  
    try{
        $stmt = $conn->prepare("INSERT INTO items (itemname, saleprice, supplyprice, description, groupID, subgroupID, unit, photo) VALUES (:itemname, :saleprice, :supplyprice, :description, :groupID, :subgroupID, :unit, :photo)");
        $stmt->execute(['itemname'=>$itemname, 'saleprice'=>$saleprice, 'supplyprice'=>$supplyprice, 'description'=>$description, 'groupID'=>$groupID, 'subgroupID'=>$subgroupID, 'unit'=>$unit, 'photo'=>$newImg]);

        $stmt = $conn->prepare("INSERT INTO stock (itemID) VALUES ((SELECT itemID FROM items WHERE itemname = '$itemname' && groupID = '$groupID' && subgroupID = '$subgroupID'))");
        $stmt->execute();
        
        $_SESSION['success'] = "Item Added Successfully!";
        header('location:../stock.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:../stock.php');
    }
}
?>