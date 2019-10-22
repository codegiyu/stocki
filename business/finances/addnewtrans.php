<?php
session_start();
include("../../includes/connect.php");
$email = $_SESSION['email'];
$staffID = $_SESSION['staffID'];

$stm = $conn->prepare("SELECT * FROM staff");
$stm->execute(); 

// $stmt = $conn->prepare("SELECT staff.staffID AS staffID FROM staff WHERE email = :email");
// $stmt->execute(['email'=>$email]);
// $row = $stmt->fetch();

$mon = $conn->prepare("SELECT money.moneyamount AS moneyamount, finances.transID AS transID, finances.transdate AS transdate, finances.transtime AS transtime FROM money JOIN finances ON money.transID = finances.transID ORDER BY transdate DESC, transtime DESC LIMIT 1");
$mon->execute();
$money = $mon->fetch();

$num = $conn->prepare("SELECT COUNT(*) AS numrows FROM money JOIN finances ON money.transID = finances.transID");
$num->execute();
$count = $num->fetch();

if(isset($_POST['addtrans'])){
    $transamount = $_POST['transamount'];
    $type = $_POST['type'];
    $transdescription = $_POST['transdescription'];
    $transdate = date("Y-m-d");
    $transtime = date("H:i:s");
    $lastmoney = $money['moneyamount'];
    $zerodebit = 0 - $transamount;
    $normalcredit = $lastmoney + $transamount;
    $normaldebit = $lastmoney - $transamount;

    try{
        $stm = $conn->prepare("INSERT INTO finances (transamount, transdate, transtime, staffID, transdescription, type) VALUES (:transamount, :transdate, :transtime, :staffID, :transdescription, :type)");
        $stm->execute(['transamount'=>$transamount, 'transdate'=>$transdate, 'transtime'=>$transtime, 'staffID'=>$staffID, 'transdescription'=>$transdescription, 'type'=>$type]);

        if ($count['numrows'] > 0 && $type == 'credit'){
            $stm = $conn->prepare("INSERT INTO money (transID, moneyamount) VALUES ((SELECT transID from finances WHERE transdate = '$transdate' AND transtime = '$transtime'), :moneyamount)");
            $stm->execute(['moneyamount'=>$normalcredit]);
        }else if ($count['numrows'] > 0 && $type == 'debit'){
            $stm = $conn->prepare("INSERT INTO money (transID, moneyamount) VALUES ((SELECT transID from finances WHERE transdate = '$transdate' AND transtime = '$transtime'), :moneyamount)");
            $stm->execute(['moneyamount'=>$normaldebit]);
        }else if ($count['numrows'] == 0 && $type == 'credit'){
            $stm = $conn->prepare("INSERT INTO money (transID, moneyamount) VALUES ((SELECT transID from finances WHERE transdate = '$transdate' AND transtime = '$transtime'), :moneyamount)");
            $stm->execute(['moneyamount'=>$transamount]);
        }else if ($count['numrows'] == 0 && $type == 'debit'){
            $stm = $conn->prepare("INSERT INTO money (transID, moneyamount) VALUES ((SELECT transID from finances WHERE transdate = '$transdate' AND transtime = '$transtime'), :moneyamount)");
            $stm->execute(['moneyamount'=>$zerodebit]);
        }
        $_SESSION['success'] = "Transaction Added Successfully!";
        header('location:../finances.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:../finances.php');
    }
}
?>