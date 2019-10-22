<?php
session_start();
include("../includes/connect.php");
if(!$_SESSION['email']){
    $_SESSION['error'] = 'You must login to access this page!';
    header("location:../login.php");
}
$email = $_SESSION['email'];
$staffID = $_SESSION['staffID'];
    $right = $conn->prepare("SELECT staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
    $right->execute(['email'=>$email]);
    $fetch = $right->fetch();

    $stmt = $conn->prepare("SELECT staff.staffID AS staffID, staff.email AS email, staff.position AS position, staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo, staffprofile.phone AS phone, staffprofile.gender AS gender, staffprofile.dob AS dob, staffprofile.originstate AS originstate, staffprofile.lga AS lga, staffprofile.hometown AS hometown, staffprofile.maritalstatus AS maritalstatus, staffaddress.address AS address, staffaddress.area AS area, staffaddress.city AS city, staffaddress.addressstate AS addressstate FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID JOIN staffaddress ON staff.staffID = staffaddress.staffID WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();

    $st = $conn->prepare("SELECT finances.transID AS transID, finances.transamount AS amount, finances.transdate AS date, finances.transtime AS time, finances.staffID AS staffID, finances.transdescription AS description, finances.type AS type, staffprofile.staffname AS staffname FROM finances JOIN staffprofile ON finances.staffID = staffprofile.staffID ORDER BY transdate DESC, transtime DESC");
    $st->execute();
    // $rows = $stmt->fetch();

    $stm = $conn->prepare("SELECT finances.staffID AS staffID, staffprofile.staffname AS staffname FROM finances JOIN staffprofile ON finances.staffID = staffprofile.staffID");
    $stm->execute();
    $sta = $stm->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Finances</title>
    <link rel="stylesheet" type="text/css" href="css/financestyle.css">
    <script src="js/finances.js"></script>
</head>
<body>
    <header>
        <?php include("header.php") ?>
    </header>
    <section id="top">
        <h2 class="container"><font color="#731D64" size="6">Transaction Records</font><font color="gray" size="6">/</font><font size="5" color="gray">Add New</font></h2>
    </section>
    <?php
        if(isset ($_SESSION['error'])) {
            echo "
            <div class= 'error'>
            <p>".$_SESSION['error']."</p>
            </div>
            ";
            unset($_SESSION['error']);
        }

        if(isset($_SESSION['success'])){
            echo "
            <div class= 'success'>
            <p>".$_SESSION['success']. "</p>
            </div>
            ";
            unset($_SESSION['success']);
        }
    ?>
    <section class="main">
        <table id="table" class="container">
            <tr id="first">
                <th>S/N</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Date</th>
                <th>Time</th>
                <th>Staff</th>
                <th>Description</th>
            </tr>
            <tr>
                <th>...</th>
                <th><button id="newtrans" onclick="document.getElementById('main').style.display='block'">Add New Transaction</button></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($st AS $i=>$rows){?>
            <tr>
                <td><?php echo $i + 1 ?></td>
                <td class="debit"><?php if($rows['type'] == 'debit'){ echo $rows['amount'];} ?></td>
                <td class="credit"><?php if($rows['type'] == 'credit'){ echo $rows['amount'];} ?></td>
                <td><?php echo $rows['date'] ?></td>
                <td><?php echo $rows['time'] ?></td>
                <td><?php echo $rows['staffname'] ?></td>
                <td><?php echo $rows['description'] ?></td>
            </tr>
            <?php } ?>
        </table>
    </section>
    <div id="main" class="modal">
        <form class="modal-content animate" method="POST" action="finances/addnewtrans.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('main').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="../img/stocki.jpg" width="100px" height="100px" alt="Avatar" class="avatar">
            </div>
            <div class="container1">
                <ul>
                    <li class="short">
                        <label>Amount</label><br>
                        <input type="number" name="transamount" class="shortinput" placeholder="0" required>
                    </li>
                    <li>
                        <label>Transaction Type</label><br>
                        <select class="soflow" name="type" id="type" placeholder="Select" required>
                            <option value selected="">Select</option>
                            <option value="credit">Credit</option>
                            <option value="debit">Debit</option>
                        </select>
                    </li>
                    <li class="desc">
                        <label>Description</label><br>
                        <textarea name="transdescription" rows="2" required></textarea>
                    </li>
                </ul>
            </div>
            <div class="bottom">
                <button id="left" type="button" onclick="document.getElementById('main').style.display='none'" class="btn" style="float:left">Cancel</button>
                <button id="right" class="btn" type="submit" name="addtrans" style="float:right">Add Transaction</button>
            </div>
        </form>
    </div>
    <footer><h5>Copyright stocki© 2019</h5></footer>
</body>
</html>
