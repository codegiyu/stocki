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

    $stm = $conn->prepare("SELECT items.itemID AS itemID, items.itemname, items.saleprice, items.supplyprice, items.description, items.unit, items.photo, groups.groupID AS groupID, groups.groupname, subgroups.subgroupID AS subroupID, subgroups.subgroupname, stock.quantity FROM items JOIN groups ON items.groupID = groups.groupID JOIN subgroups ON items.subgroupID = subgroups.subgroupID JOIN stock ON items.itemID = stock.itemID ORDER BY itemname ASC");
    $stm->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catalogue</title>
    <link rel="stylesheet" type="text/css" href="css/cataloguestyle.css">
</head>
<body>
    <header>
        <?php include("header.php") ?>
    </header>
    <div class="aside">

    </div>
    <section>
        <div id="header">
            <table id="one">
                <col style="width:25%">
                <col style="width:20%">
                <col style="width:15%">
                <col style="width:15%">
                <col style="width:25%">
                <tr>
                    <th><p>IMAGE</p></th>
                    <th><p>NAME/SALE PRICE</P></th>
                    <th><p>GROUP</p></th>
                    <th><p>SUB-GROUP</p></th>
                    <th><p>DESCRIPTION</p></th>
                </tr>
            </table>
        </div>
        <div id="main">
            <?php foreach($stm AS $rows) { ?>
                <div class="content">
                    <table id="two">
                        <col style="width:25%">
                        <col style="width:20%">
                        <col style="width:15%">
                        <col style="width:15%">
                        <col style="width:25%">
                        <tr>
                            <td><img src="../img/<?php echo $rows['photo'] ?>" class="itempic" width="200px" height="180px"></td>
                            <td>
                                <div class="name_price">
                                    <div class="name"><p><?php echo $rows['itemname'] ?></p></div>
                                    <div class="price"><p>₦<?php echo $rows['saleprice'] ?></p></div>
                                </div>
                            </td>
                            <td><div class="write"><p><?php echo $rows['groupname'] ?></p></div></td>
                            <td><div class="write"><p><?php echo $rows['subgroupname'] ?></p></div></td>
                            <td><div id="description" class="write"><p><?php echo $rows['description'] ?></p></div></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        </div>
    </section>
    <footer><h5>Copyright stocki© 2019</h5></footer>

</body>
</html>