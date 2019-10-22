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

if(isset($_POST['addsupply'])){
    $itemID = array($_POST['itemID1'], $_POST['itemID2'], $_POST['itemID3'], $_POST['itemID4'], $_POST['itemID5'], $_POST['itemID6'], $_POST['itemID7'], $_POST['itemID8']);
    $supplyprice = array($_POST['supplyprice1'], $_POST['supplyprice2'], $_POST['supplyprice3'], $_POST['supplyprice4'], $_POST['supplyprice5'], $_POST['supplyprice6'], $_POST['supplyprice7'], $_POST['supplyprice8']);
    $supplyquantity = array($_POST['quantity1'], $_POST['quantity2'], $_POST['quantity3'], $_POST['quantity4'], $_POST['quantity5'], $_POST['quantity6'], $_POST['quantity7'], $_POST['quantity8']);
    $supplytotalprice = array($_POST['totalprice1'], $_POST['totalprice2'], $_POST['totalprice3'], $_POST['totalprice4'], $_POST['totalprice5'], $_POST['totalprice6'], $_POST['totalprice7'], $_POST['totalprice8'], $_POST['grandtotal']);
    $supplytime = date("H:i:s");
    $supplydate = date("Y-m-d");
    $staffID = $_SESSION['staffID'];
    $expdate = array($_POST['expdate1'], $_POST['expdate2'], $_POST['expdate3'], $_POST['expdate4'], $_POST['expdate5'], $_POST['expdate6'], $_POST['expdate7'], $_POST['expdate8']);
    $type = 'debit';
    $lastmoney = $money['moneyamount'];
    $normaldebit = $lastmoney - $supplytotalprice[8];

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

    $stockchange = array($laststock0 + $supplyquantity[0], $laststock1 + $supplyquantity[1], $laststock2 + $supplyquantity[2], $laststock3 + $supplyquantity[3], $laststock4 + $supplyquantity[4], $laststock5 + $supplyquantity[5], $laststock6 + $supplyquantity[6], $laststock7 + $supplyquantity[7]);

    try{
        $stm = $conn->prepare("INSERT INTO invoices (invoicedate, invoicetime) VALUES (:invoicedate, :invoicetime)");
        $stm->execute(['invoicedate'=>$supplydate, 'invoicetime'=>$supplytime]);

        $inv = $conn->prepare("SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'");
        $inv->execute();
        $invoice = $inv->fetch();
        $invoiceID = $invoice['invoiceID'];
        $transdescription = 'Supply made on ' . $supplydate . ' at ' . $supplytime . ',' . ' Invoice#' . $invoiceID . '.';

        $stm = $conn->prepare("INSERT INTO supplies (itemID, supplyquantity, supplyprice, supplydate, supplytime, staffID, expdate, supplytotalprice, unit, invoiceID) VALUES (:itemID, :supplyquantity, :supplyprice, :supplydate, :supplytime, :staffID, :expdate, :supplytotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[0]'), (SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'))");
        $stm->execute(['itemID'=>$itemID[0], 'supplyquantity'=>$supplyquantity[0], 'supplyprice'=>$supplyprice[0], 'supplydate'=>$supplydate, 'supplytime'=>$supplytime, 'staffID'=>$staffID, 'expdate'=>$expdate[0], 'supplytotalprice'=>$supplytotalprice[0]]);

        $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[0]'");
        $stm->execute(['quantity'=>$stockchange[0]]);
        
        if ($itemID[1] != ""){
            $stm = $conn->prepare("INSERT INTO supplies (itemID, supplyquantity, supplyprice, supplydate, supplytime, staffID, expdate, supplytotalprice, unit, invoiceID) VALUES (:itemID, :supplyquantity, :supplyprice, :supplydate, :supplytime, :staffID, :expdate, :supplytotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[1]'), (SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'))");
            $stm->execute(['itemID'=>$itemID[1], 'supplyquantity'=>$supplyquantity[1], 'supplyprice'=>$supplyprice[1], 'supplydate'=>$supplydate, 'supplytime'=>$supplytime, 'staffID'=>$staffID, 'expdate'=>$expdate[1], 'supplytotalprice'=>$supplytotalprice[1]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[1]'");
            $stm->execute(['quantity'=>$stockchange[1]]);
        }

        if ($itemID[2] != ""){
            $stm = $conn->prepare("INSERT INTO supplies (itemID, supplyquantity, supplyprice, supplydate, supplytime, staffID, expdate, supplytotalprice, unit, invoiceID) VALUES (:itemID, :supplyquantity, :supplyprice, :supplydate, :supplytime, :staffID, :expdate, :supplytotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[2]'), (SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'))");
            $stm->execute(['itemID'=>$itemID[2], 'supplyquantity'=>$supplyquantity[2], 'supplyprice'=>$supplyprice[2], 'supplydate'=>$supplydate, 'supplytime'=>$supplytime, 'staffID'=>$staffID, 'expdate'=>$expdate[2], 'supplytotalprice'=>$supplytotalprice[2]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[2]'");
            $stm->execute(['quantity'=>$stockchange[2]]);
        }

        if ($itemID[3] != ""){
            $stm = $conn->prepare("INSERT INTO supplies (itemID, supplyquantity, supplyprice, supplydate, supplytime, staffID, expdate, supplytotalprice, unit, invoiceID) VALUES (:itemID, :supplyquantity, :supplyprice, :supplydate, :supplytime, :staffID, :expdate, :supplytotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[3]'), (SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'))");
            $stm->execute(['itemID'=>$itemID[3], 'supplyquantity'=>$supplyquantity[3], 'supplyprice'=>$supplyprice[3], 'supplydate'=>$supplydate, 'supplytime'=>$supplytime, 'staffID'=>$staffID, 'expdate'=>$expdate[3], 'supplytotalprice'=>$supplytotalprice[3]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[3]'");
            $stm->execute(['quantity'=>$stockchange[3]]);
        }

        if ($itemID[4] != ""){
            $stm = $conn->prepare("INSERT INTO supplies (itemID, supplyquantity, supplyprice, supplydate, supplytime, staffID, expdate, supplytotalprice, unit, invoiceID) VALUES (:itemID, :supplyquantity, :supplyprice, :supplydate, :supplytime, :staffID, :expdate, :supplytotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[4]'), (SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'))");
            $stm->execute(['itemID'=>$itemID[4], 'supplyquantity'=>$supplyquantity[4], 'supplyprice'=>$supplyprice[4], 'supplydate'=>$supplydate, 'supplytime'=>$supplytime, 'staffID'=>$staffID, 'expdate'=>$expdate[4], 'supplytotalprice'=>$supplytotalprice[4]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[4]'");
            $stm->execute(['quantity'=>$stockchange[4]]);
        }

        if ($itemID[5] != ""){
            $stm = $conn->prepare("INSERT INTO supplies (itemID, supplyquantity, supplyprice, supplydate, supplytime, staffID, expdate, supplytotalprice, unit, invoiceID) VALUES (:itemID, :supplyquantity, :supplyprice, :supplydate, :supplytime, :staffID, :expdate, :supplytotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[5]'), (SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'))");
            $stm->execute(['itemID'=>$itemID[5], 'supplyquantity'=>$supplyquantity[5], 'supplyprice'=>$supplyprice[5], 'supplydate'=>$supplydate, 'supplytime'=>$supplytime, 'staffID'=>$staffID, 'expdate'=>$expdate[5], 'supplytotalprice'=>$supplytotalprice[5]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[5]'");
            $stm->execute(['quantity'=>$stockchange[5]]);
        }

        if ($itemID[6] != ""){
            $stm = $conn->prepare("INSERT INTO supplies (itemID, supplyquantity, supplyprice, supplydate, supplytime, staffID, expdate, supplytotalprice, unit, invoiceID) VALUES (:itemID, :supplyquantity, :supplyprice, :supplydate, :supplytime, :staffID, :expdate, :supplytotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[6]'), (SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'))");
            $stm->execute(['itemID'=>$itemID[6], 'supplyquantity'=>$supplyquantity[6], 'supplyprice'=>$supplyprice[6], 'supplydate'=>$supplydate, 'supplytime'=>$supplytime, 'staffID'=>$staffID, 'expdate'=>$expdate[6], 'supplytotalprice'=>$supplytotalprice[6]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[6]'");
            $stm->execute(['quantity'=>$stockchange[6]]);
        }

        if ($itemID[7] != ""){
            $stm = $conn->prepare("INSERT INTO supplies (itemID, supplyquantity, supplyprice, supplydate, supplytime, staffID, expdate, supplytotalprice, unit, invoiceID) VALUES (:itemID, :supplyquantity, :supplyprice, :supplydate, :supplytime, :staffID, :expdate, :supplytotalprice, (SELECT unit FROM items WHERE itemID = '$itemID[7]'), (SELECT invoiceID from invoices WHERE invoicedate = '$supplydate' AND invoicetime = '$supplytime'))");
            $stm->execute(['itemID'=>$itemID[7], 'supplyquantity'=>$supplyquantity[7], 'supplyprice'=>$supplyprice[7], 'supplydate'=>$supplydate, 'supplytime'=>$supplytime, 'staffID'=>$staffID, 'expdate'=>$expdate[7], 'supplytotalprice'=>$supplytotalprice[7]]);

            $stm = $conn->prepare("UPDATE stock SET quantity = :quantity WHERE itemID = '$itemID[7]'");
            $stm->execute(['quantity'=>$stockchange[7]]);
        }

        $stm = $conn->prepare("INSERT INTO finances (transamount, transdate, transtime, staffID, transdescription, type) VALUES (:transamount, :transdate, :transtime, :staffID, :transdescription, :type)");
        $stm->execute(['transamount'=>$supplytotalprice[8], 'transdate'=>$supplydate, 'transtime'=>$supplytime, 'staffID'=>$staffID, 'transdescription'=>$transdescription, 'type'=>$type]);

        $stm = $conn->prepare("INSERT INTO money (transID, moneyamount) VALUES ((SELECT transID from finances WHERE transdate = '$supplydate' AND transtime = '$supplytime'), :moneyamount)");
        $stm->execute(['moneyamount'=>$normaldebit]);
    
        $_SESSION['success'] = "New Supply Record Created!";
        header('location:../supplies.php');
    }catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:../supplies.php');
    }
}
?>