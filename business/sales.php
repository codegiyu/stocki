<?php
session_start();
include("../includes/connect.php");
if(!$_SESSION['email']){
    $_SESSION['error'] = 'You must login to access this page!';
    header("location:../login.php");
}
$email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT * FROM staffprofile JOIN staff ON staffprofile.staffID = staff.staffID");
    $stmt->execute(['email'=>$email]);

    $right = $conn->prepare("SELECT staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
    $right->execute(['email'=>$email]);
    $fetch = $right->fetch();

    $stmt = $conn->prepare("SELECT staff.staffID AS staffID, staff.email AS email, staff.position AS position, staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo, staffprofile.phone AS phone, staffprofile.gender AS gender, staffprofile.dob AS dob, staffprofile.originstate AS originstate, staffprofile.lga AS lga, staffprofile.hometown AS hometown, staffprofile.maritalstatus AS maritalstatus, staffaddress.address AS address, staffaddress.area AS area, staffaddress.city AS city, staffaddress.addressstate AS addressstate FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID JOIN staffaddress ON staff.staffID = staffaddress.staffID WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();

    $stamt = $conn->prepare("SELECT * FROM items");
    $stamt->execute();

    $stamt1 = $conn->prepare("SELECT * FROM items");
    $stamt1->execute();

    $stamt2 = $conn->prepare("SELECT * FROM items");
    $stamt2->execute();

    $stamt3 = $conn->prepare("SELECT * FROM items");
    $stamt3->execute();

    $stamt4 = $conn->prepare("SELECT * FROM items");
    $stamt4->execute();

    $stamt5 = $conn->prepare("SELECT * FROM items");
    $stamt5->execute();

    $stamt6 = $conn->prepare("SELECT * FROM items");
    $stamt6->execute();

    $stamt7 = $conn->prepare("SELECT * FROM items");
    $stamt7->execute();

    $sql = $conn->prepare("SELECT * FROM items");
    $sql->execute();
    $item = $sql->fetch();

    $sal = $conn->prepare("SELECT sales.itemID AS itemID, items.itemname AS itemname, sales.saleprice AS price, sales.salequantity AS quantity, sales.saletotalprice AS total, sales.saledate AS date, sales.saletime AS time, sales.receiptID, sales.staffID AS staffID, staffprofile.staffname AS staffname FROM sales JOIN items ON sales.itemID = items.itemID JOIN staffprofile ON sales.staffID = staffprofile.staffID ORDER BY date DESC, time DESC");
    $sal->execute();
    // $sales = $sal->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales</title>
    <link rel="stylesheet" type="text/css" href="css/salesstyle.css">
    <script src="js/sales.js"></script>
</head>
<body>
    <header>
        <?php include("header.php") ?>
    </header>
    <section id="top">
        <h2 class="container"><font color="#731D64" size="6">Sales Records</font><font color="gray" size="6">/</font><font size="5" color="gray">Add New</font></h2>
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
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Sale Date</th>
                <th>Sale Time</th>
                <th>Receipt ID</th>
                <th>Staff</th>
            </tr>
            <tr>
                <th>...</th>
                <th><button id="newsale" onclick="document.getElementById('main').style.display='block'">Make a sale</button></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($sal AS $i=>$rows){ ?>
            <tr>
                <td><?php echo $i + 1 ?></td>
                <td><?php echo $rows['itemname'] ?></td>
                <td><?php echo $rows['price'] ?></td>
                <td><?php echo $rows['quantity'] ?></td>
                <td><?php echo $rows['total'] ?></td>
                <td><?php echo $rows['date'] ?></td>
                <td><?php echo $rows['time'] ?></td>
                <td><?php echo $rows['receiptID'] ?></td>
                <td><?php echo $rows['staffname'] ?></td>
            </tr>
            <?php } ?>
        </table>
    </section>
    <div id="main" class="modal">
        <form class="modal-content animate" method="POST" action="sales/addsaleprocess.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('main').style.display='none'" class="close" title="Close Modal">&times;</span>
                <div class="container">
                    <img src="../img/stocki.jpg" width="65px" height="65px" alt="Avatar" class="avatar">
                </div>
            </div>
            <div class="container1">
                <table id="table1" class="container1" border="0" width="100%">
                    <col style="width:5%">
                    <col style="width:41%">
                    <col style="width:18%">
                    <col style="width:18%">
                    <col style="width:18%">
                    <thead>
                    <tr id="second">
                        <th>S/N</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>                      
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <select class="soflow" name="itemID1" required>
                                <option value selected="selected"></option>
                                <?php foreach($stamt AS $item) { ?>
                                    <option value="<?php echo $item['itemID'] ?>"><?php echo $item['itemname'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="number" name="saleprice1" id="sp1" class="shortinput" placeholder="0" required></td>
                        <td><input type="number" name="quantity1" id="qty1" class="shortinput" placeholder="0" onchange="computeTotal1()" required></td>
                        <td><input type="number" name="totalprice1" id="tp1" class="shortinput" placeholder="0" required></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <select class="soflow" name="itemID2">
                                <option value selected="selected"></option>
                                <?php foreach($stamt1 AS $item) { ?>
                                    <option value="<?php echo $item['itemID'] ?>"><?php echo $item['itemname'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="number" name="saleprice2" id="sp2" class="shortinput" placeholder="0"></td>
                        <td><input type="number" name="quantity2" id="qty2" class="shortinput" onchange="computeTotal2()" placeholder="0"></td>
                        <td><input type="number" name="totalprice2" id="tp2" class="shortinput" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <select class="soflow" name="itemID3">
                                <option value selected="selected"></option>
                                <?php foreach($stamt2 AS $item) { ?>
                                    <option value="<?php echo $item['itemID'] ?>"><?php echo $item['itemname'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="number" name="saleprice3" id="sp3" class="shortinput" placeholder="0"></td>
                        <td><input type="number" name="quantity3" id="qty3" class="shortinput" onchange="computeTotal3()" placeholder="0"></td>
                        <td><input type="number" name="totalprice3" id="tp3" class="shortinput" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>
                            <select class="soflow" name="itemID4">
                                <option value selected="selected"></option>
                                <?php foreach($stamt3 AS $item) { ?>
                                    <option value="<?php echo $item['itemID'] ?>"><?php echo $item['itemname'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="number" name="saleprice4" id="sp4" class="shortinput" placeholder="0"></td>
                        <td><input type="number" name="quantity4" id="qty4" class="shortinput" onchange="computeTotal4()" placeholder="0"></td>
                        <td><input type="number" name="totalprice4" id="tp4" class="shortinput" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>
                            <select class="soflow" name="itemID5">
                                <option value selected="selected"></option>
                                <?php foreach($stamt4 AS $item) { ?>
                                    <option value="<?php echo $item['itemID'] ?>"><?php echo $item['itemname'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="number" name="saleprice5" id="sp5" class="shortinput" placeholder="0"></td>
                        <td><input type="number" name="quantity5" id="qty5" class="shortinput" onchange="computeTotal5()" placeholder="0"></td>
                        <td><input type="number" name="totalprice5" id="tp5" class="shortinput" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>
                            <select class="soflow" name="itemID6">
                                <option value selected="selected"></option>
                                <?php foreach($stamt5 AS $item) { ?>
                                    <option value="<?php echo $item['itemID'] ?>"><?php echo $item['itemname'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="number" name="saleprice6" id="sp6" class="shortinput" placeholder="0"></td>
                        <td><input type="number" name="quantity6" id="qty6" class="shortinput" onchange="computeTotal6()" placeholder="0"></td>
                        <td><input type="number" name="totalprice6" id="tp6" class="shortinput" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>
                            <select class="soflow" name="itemID7">
                                <option value selected="selected"></option>
                                <?php foreach($stamt6 AS $item) { ?>
                                    <option value="<?php echo $item['itemID'] ?>"><?php echo $item['itemname'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="number" name="saleprice7" id="sp7" class="shortinput" placeholder="0"></td>
                        <td><input type="number" name="quantity7" id="qty7" class="shortinput" onchange="computeTotal7()" placeholder="0"></td>
                        <td><input type="number" name="totalprice7" id="tp7" class="shortinput" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>
                            <select class="soflow" name="itemID8">
                                <option value selected="selected"></option>
                                <?php foreach($stamt7 AS $item) { ?>
                                    <option value="<?php echo $item['itemID'] ?>"><?php echo $item['itemname'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input type="number" name="saleprice8" id="sp8" class="shortinput" placeholder="0"></td>
                        <td><input type="number" name="quantity8" id="qty8" class="shortinput" onchange="computeTotal8()" placeholder="0"></td>
                        <td><input type="number" name="totalprice8" id="tp8" class="shortinput" placeholder="0"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Grand Total:</b></td>
                        <td><input type="number" name="grandtotal" id="tp9" class="shortinput" placeholder="0" onclick="computeGrandTotal()" required></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="bottom">
                <button id="left" type="button" onclick="document.getElementById('main').style.display='none'" class="btn" style="float:left">Cancel</button>
                <button id="right" class="btn" type="submit" name="addsale" style="float:right">Add Sale</button>
            </div>
        </form>
    </div>
    <footer><h5>Copyright stocki© 2019</h5></footer>
</body>
</html>