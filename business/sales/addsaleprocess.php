<?php
session_start();
include("../../includes/connect.php");
$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT staff.staffID AS staffID FROM staff WHERE email = :email");
$stmt->execute(['email'=>$email]);
$row = $stmt->fetch();

$mon = $conn->prepare("SELECT money.moneyamount AS moneyamount, finances.transID AS transID, finances.transdate AS transdate, finances.transtime AS transtime FROM money JOIN finances ON money.transID = finances.transID ORDER BY transdate DESC, transtime DESC LIMIT 1");
$mon->execute();
$money = $mon->fetch();

if(isset($_POST['addsale'])){
    $itemID = array($_POST['itemID1'], $_POST['itemID2'], $_POST['itemID3'], $_POST['itemID4'], $_POST['itemID5'], $_POST['itemID6'], $_POST['itemID7'], $_POST['itemID8']);
    $saleprice = array($_POST['saleprice1'], $_POST['saleprice2'], $_POST['saleprice3'], $_POST['saleprice4'], $_POST['saleprice5'], $_POST['saleprice6'], $_POST['saleprice7'], $_POST['saleprice8']);
    $salequantity = array($_POST['quantity1'], $_POST['quantity2'], $_POST['quantity3'], $_POST['quantity4'], $_POST['quantity5'], $_POST['quantity6'], $_POST['quantity7'], $_POST['quantity8']);
    $saletotalprice = array($_POST['totalprice1'], $_POST['totalprice2'], $_POST['totalprice3'], $_POST['totalprice4'], $_POST['totalprice5'], $_POST['totalprice6'], $_POST['totalprice7'], $_POST['totalprice8'], $_POST['grandtotal']);
    $saletime = date("H:i:s");
    $saledate = date("Y-m-d");
    $staffID = $row['staffID'];
    $type = 'credit';
    $lastmoney = $money['moneyamount'];
    $normalcredit = $lastmoney + $saletotalprice[8];

    $stock0 = $conn->prepare("SELECT * FROM stock WHERE itemID = :itemID");
    $stock0->execute(['itemID'=>$itemID[0]]);
    $col0 = $stock0->fetch();
    $laststock0 = $col0['quantity'];
    
    $stock1 = $conn->prepare("SELECT * FROM stock WHERE itemID = :itemID");
    $stock1->execute(['itemID'=>$itemID[1]]);
    $col1 = $stock1->fetch();
    $laststock1 = $col1['quantity'];

    $stock2 = $conn->prepare("SELECT * FROM stock WHERE itemID = :itemID");
    $stock2->execute(['itemID'=>$itemID[2]]);
    $col2 = $stock2->fetch();
    $laststock2 = $col2['quantity'];

    $stock3 = $conn->prepare("SELECT * FROM stock WHERE itemID = :itemID");
    $stock3->execute(['itemID'=>$itemID[3]]);
    $col3 = $stock3->fetch();
    $laststock3 = $col3['quantity'];

    $stock4 = $conn->prepare("SELECT * FROM stock WHERE itemID = :itemID");
    $stock4->execute(['itemID'=>$itemID[4]]);
    $col4 = $stock4->fetch();
    $laststock4 = $col4['quantity'];

    $stock5 = $conn->prepare("SELECT * FROM stock WHERE itemID = :itemID");
    $stock5->execute(['itemID'=>$itemID[5]]);
    $col5 = $stock5->fetch();
    $laststock5 = $col5['quantity'];

    $stock6 = $conn->prepare("SELECT * FROM stock WHERE itemID = :itemID");
    $stock6->execute(['itemID'=>$itemID[6]]);
    $col6 = $stock6->fetch();
    $laststock6 = $col6['quantity'];

    $stock7 = $conn->prepare("SELECT * FROM stock WHERE itemID = :itemID");
    $stock7->execute(['itemID'=>$itemID[7]]);
    $col7 = $stock7->fetch();
    $laststock7 = $col7['quantity'];

    $stockchange = array($laststock0 - $salequantity[0], $laststock1 - $salequantity[1], $laststock2 - $salequantity[2], $laststock3 - $salequantity[3], $laststock4 - $salequantity[4], $laststock5 - $salequantity[5], $laststock6 - $salequantity[6], $laststock7 - $salequantity[7]);

    try{
        $stm = $conn->prepare("INSERT INTO receipts (receiptdate, receipttime) VALUES (:receiptdate, :receipttime)");
        $stm->execute(['receiptdate'=>$saledate, 'receipttime'=>$saletime]);

        $inv = $conn->prepare("SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'");
        $inv->execute();
        $receipt = $inv->fetch();
        $receiptID = $receipt['receiptID'];
        $transdescription = 'Sale made on ' . $saledate . ' at ' . $saletime . ',' . ' receipt#' . $receiptID . '.';

        $stm = $conn->prepare("INSERT INTO sales (itemID, salequantity, saleprice, saledate, saletime, staffID, saletotalprice, unit, receiptID) VALUES (:itemID, :salequantity, :saleprice, :saledate, :saletime, :staffID,  :saletotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[0]'), (SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'))");
        $stm->execute(['itemID'=>$itemID[0], 'salequantity'=>$salequantity[0], 'saleprice'=>$saleprice[0], 'saledate'=>$saledate, 'saletime'=>$saletime, 'staffID'=>$staffID, 'saletotalprice'=>$saletotalprice[0]]);

        $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[0]'");
        $stm->execute(['quantity'=>$stockchange[0]]);
        
        if ($itemID[1] != ""){
            $stm = $conn->prepare("INSERT INTO sales (itemID, salequantity, saleprice, saledate, saletime, staffID, saletotalprice, unit, receiptID) VALUES (:itemID, :salequantity, :saleprice, :saledate, :saletime, :staffID,  :saletotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[1]'), (SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'))");
            $stm->execute(['itemID'=>$itemID[1], 'salequantity'=>$salequantity[1], 'saleprice'=>$saleprice[1], 'saledate'=>$saledate, 'saletime'=>$saletime, 'staffID'=>$staffID, 'saletotalprice'=>$saletotalprice[1]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[1]'");
            $stm->execute(['quantity'=>$stockchange[1]]);
        }

        if ($itemID[2] != ""){
            $stm = $conn->prepare("INSERT INTO sales (itemID, salequantity, saleprice, saledate, saletime, staffID, saletotalprice, unit, receiptID) VALUES (:itemID, :salequantity, :saleprice, :saledate, :saletime, :staffID,  :saletotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[2]'), (SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'))");
            $stm->execute(['itemID'=>$itemID[2], 'salequantity'=>$salequantity[2], 'saleprice'=>$saleprice[2], 'saledate'=>$saledate, 'saletime'=>$saletime, 'staffID'=>$staffID, 'saletotalprice'=>$saletotalprice[2]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[2]'");
            $stm->execute(['quantity'=>$stockchange[2]]);
        }

        if ($itemID[3] != ""){
            $stm = $conn->prepare("INSERT INTO sales (itemID, salequantity, saleprice, saledate, saletime, staffID, saletotalprice, unit, receiptID) VALUES (:itemID, :salequantity, :saleprice, :saledate, :saletime, :staffID,  :saletotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[3]'), (SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'))");
            $stm->execute(['itemID'=>$itemID[3], 'salequantity'=>$salequantity[3], 'saleprice'=>$saleprice[3], 'saledate'=>$saledate, 'saletime'=>$saletime, 'staffID'=>$staffID, 'saletotalprice'=>$saletotalprice[3]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[3]'");
            $stm->execute(['quantity'=>$stockchange[3]]);
        }

        if ($itemID[4] != ""){
            $stm = $conn->prepare("INSERT INTO sales (itemID, salequantity, saleprice, saledate, saletime, staffID, saletotalprice, unit, receiptID) VALUES (:itemID, :salequantity, :saleprice, :saledate, :saletime, :staffID,  :saletotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[4]'), (SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'))");
            $stm->execute(['itemID'=>$itemID[4], 'salequantity'=>$salequantity[4], 'saleprice'=>$saleprice[4], 'saledate'=>$saledate, 'saletime'=>$saletime, 'staffID'=>$staffID, 'saletotalprice'=>$saletotalprice[4]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[4]'");
            $stm->execute(['quantity'=>$stockchange[4]]);
        }

        if ($itemID[5] != ""){
            $stm = $conn->prepare("INSERT INTO sales (itemID, salequantity, saleprice, saledate, saletime, staffID, saletotalprice, unit, receiptID) VALUES (:itemID, :salequantity, :saleprice, :saledate, :saletime, :staffID,  :saletotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[5]'), (SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'))");
            $stm->execute(['itemID'=>$itemID[5], 'salequantity'=>$salequantity[5], 'saleprice'=>$saleprice[5], 'saledate'=>$saledate, 'saletime'=>$saletime, 'staffID'=>$staffID, 'saletotalprice'=>$saletotalprice[5]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[5]'");
            $stm->execute(['quantity'=>$stockchange[5]]);
        }

        if ($itemID[6] != ""){
            $stm = $conn->prepare("INSERT INTO sales (itemID, salequantity, saleprice, saledate, saletime, staffID, saletotalprice, unit, receiptID) VALUES (:itemID, :salequantity, :saleprice, :saledate, :saletime, :staffID,  :saletotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[6]'), (SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'))");
            $stm->execute(['itemID'=>$itemID[6], 'salequantity'=>$salequantity[6], 'saleprice'=>$saleprice[6], 'saledate'=>$saledate, 'saletime'=>$saletime, 'staffID'=>$staffID, 'saletotalprice'=>$saletotalprice[6]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[6]'");
            $stm->execute(['quantity'=>$stockchange[6]]);
        }

        if ($itemID[7] != ""){
            $stm = $conn->prepare("INSERT INTO sales (itemID, salequantity, saleprice, saledate, saletime, staffID, saletotalprice, unit, receiptID) VALUES (:itemID, :salequantity, :saleprice, :saledate, :saletime, :staffID,  :saletotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[7]'), (SELECT receiptID from receipts WHERE receiptdate = '$saledate' AND receipttime = '$saletime'))");
            $stm->execute(['itemID'=>$itemID[7], 'salequantity'=>$salequantity[7], 'saleprice'=>$saleprice[7], 'saledate'=>$saledate, 'saletime'=>$saletime, 'staffID'=>$staffID, 'saletotalprice'=>$saletotalprice[7]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[7]'");
            $stm->execute(['quantity'=>$stockchange[7]]);
        }

        $stm = $conn->prepare("INSERT INTO finances (transamount, transdate, transtime, staffID, transdescription, type) VALUES (:transamount, :transdate, :transtime, :staffID, :transdescription, :type)");
        $stm->execute(['transamount'=>$saletotalprice[8], 'transdate'=>$saledate, 'transtime'=>$saletime, 'staffID'=>$staffID, 'transdescription'=>$transdescription, 'type'=>$type]);

        $stm = $conn->prepare("INSERT INTO money (transID, moneyamount) VALUES ((SELECT transID from finances WHERE transdate = '$saledate' AND transtime = '$saletime'), :moneyamount)");
        $stm->execute(['moneyamount'=>$normalcredit]);
    
        $_SESSION['success'] = "New sale Record Created!";
        header('location:../sales.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:../sales.php');
    }
}
?>