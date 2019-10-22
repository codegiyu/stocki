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

    $stm = $conn->prepare("SELECT items.itemID AS itemID, items.itemname, items.saleprice, items.supplyprice, items.description, items.unit, groups.groupID AS groupID, groups.groupname, subgroups.subgroupID AS subroupID, subgroups.subgroupname, stock.quantity FROM items JOIN groups ON items.groupID = groups.groupID JOIN subgroups ON items.subgroupID = subgroups.subgroupID JOIN stock ON items.itemID = stock.itemID ORDER BY itemname ASC");
    $stm->execute();
    // $rows = $stm->fetch();

    $stmt = $conn->prepare("SELECT staff.staffID AS staffID, staff.email AS email, staff.position AS position, staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo, staffprofile.phone AS phone, staffprofile.gender AS gender, staffprofile.dob AS dob, staffprofile.originstate AS originstate, staffprofile.lga AS lga, staffprofile.hometown AS hometown, staffprofile.maritalstatus AS maritalstatus, staffaddress.address AS address, staffaddress.area AS area, staffaddress.city AS city, staffaddress.addressstate AS addressstate FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID JOIN staffaddress ON staff.staffID = staffaddress.staffID WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();

    $stamt = $conn->prepare("SELECT * FROM groups");
    $stamt->execute();

    $stamts = $conn->prepare("SELECT * FROM groups");
    $stamts->execute();

    $sg = $conn->prepare("SELECT * FROM subgroups");
    $sg->execute();
    
    $right = $conn->prepare("SELECT staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
    $right->execute(['email'=>$email]);
    $fetch = $right->fetch();

    $sql = $conn->prepare("SELECT * FROM groups");
    $sql->execute();
    $group = $sql->fetch();

    $sq = $conn->prepare("SELECT * FROM subgroups");
    $sq->execute();
    $subgroup = $sq->fetch();

    // $ex = $conn->prepare("SELECT items.itemID as itemID, supplies.expdate AS expdate FROM items join supplies on items.itemID = supplies.itemID where items.itemID = '2' order by expdate desc limit 1");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Current Stock</title>
    <link rel="stylesheet" type="text/css" href="css/stockstyle.css">
    <script src="js/stock.js"></script>
</head>
<body>
    <header>
        <?php include("header.php") ?>
    </header>
    <section id="top">
        <h2 class="container"><font color="#731D64" size="6">Item Records</font><font color="gray" size="6">/</font><font size="5" color="gray">Add New</font></h2>
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
                <th>Item</th>
                <th>Group</th>
                <th>Sub-Group</th>
                <th>Sale Price</th>
                <th>Supply Price</th>
                <th>Quantity</th>
                <th>Exp. Date</th>
            </tr>
            <tr>
                <th>...</th>
                <th><button id="newitem" onclick="document.getElementById('main').style.display='block'">Add new Item</button></th>
                <th><button id="newgroup" onclick="document.getElementById('groups').style.display='block'">Add new Group</button></th>
                <th><button id="newsubgroup" onclick="document.getElementById('subgroups').style.display='block'">Add new Subgroup</button></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($stm AS $i=>$rows){ ?>
            <tr>
                <td><?php echo $i + 1 ?></td>
                <td><?php echo $rows['itemname'] ?></td>
                <td><?php echo $rows['groupname'] ?></td>
                <td><?php echo $rows['subgroupname'] ?></td>
                <td><?php echo $rows['saleprice'] ?></td>
                <td><?php echo $rows['supplyprice'] ?></td>
                <td><?php echo $rows['quantity'] ?></td>
                <td></td>
            </tr>
            <?php } ?>
        </table>
    </section>
    <div id="main" class="modal">
        <form class="modal-content animate" method="POST" action="stock/additemprocess.php" enctype="multipart/form-data">
            <div class="imgcontainer">
                <img src="../img/stocki.jpg" width="65px" height="65px" alt="Avatar" class="avatar">
                <span onclick="document.getElementById('main').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>
            <div id="data" class="container1">
                <ul>
                    <li>
                        <label>Item Name</label><br>
                        <input type="text" name="itemname" class="longinput" placeholder="Product Name" required>
                    </li>
                    <li class="short">
                        <label>Unit</label><br>
                        <input type="text" name="unit" class="shortinput" placeholder="Unit" required>
                    </li>
                    <li class="short">
                        <label>Sale Price</label><br>
                        <input type="number" name="saleprice" class="shortinput" placeholder="0" required>
                    </li>
                    <li class="short">
                        <label>Supply Price</label><br>
                        <input type="number" name="supplyprice" class="shortinput" placeholder="0" required>
                    </li>
                    <li class="select">
                        <label>Group Name</label><br>
                        <select class="soflow" name="groupID" id="group" required>
                            <option value selected="selected">Select...</option>
                            <?php foreach($stamt AS $group) { ?>
                                <option value="<?php echo $group['groupID'] ?>"><?php echo $group['groupname'] ?></option>
                            <?php } ?>
                        </select>
                    </li>
                    <li class="select subgroup">
                        <label>Subgroup Name</label><br>
                        <select class="soflow" name="subgroupID" id="subgroup" required>
                            <option value selected="selected">Select...</option>
                            <?php foreach($sg AS $subgroup) { ?>
                                <option value="<?php echo $subgroup['subgroupID'] ?>"><?php echo $subgroup['subgroupname'] ?></option>
                            <?php } ?>
                        </select>
                    </li>
                    <li class="desc">
                        <label>Item Photo <i>(Please select an image file less than 8mb)</i></label><br>
                        <input type="file" name="photo" class="longinput">
                    </li>
                    <li class="desc">
                        <label>Description</label><br>
                        <textarea name="description" rows="4" required></textarea>
                    </li>
                </ul>
            </div>
            <div class="bottom">
                <button id="left" type="button" onclick="document.getElementById('main').style.display='none'" class="btn" style="float:left">Cancel</button>
                <button id="right" class="btn" type="submit" name="additem" style="float:right">Add Product</button>
            </div>
        </form>
    </div>
    <div id="groups" class="modal">
        <form class="modal-content2 animate" method="POST" action="stock/addgroupprocess.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('groups').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>
            <div class="container1">
                <label>Group Name</label><br>
                <input type="text" name="groupname" class="longinput" placeholder="Group Name" required>
            </div>
            <div class="bottom">
                <button id="left" type="button" onclick="document.getElementById('groups').style.display='none'" class="btn" style="float:left">Cancel</button>
                <button id="right" class="btn" type="submit" name="addgroup" style="float:right">Add Group</button>
            </div>
        </form>
    </div>
    <div id="subgroups" class="modal">
        <form class="modal-content3 animate" method="POST" action="stock/addsubgroupprocess.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('subgroups').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>
            <div class="container1">
                <label>Group Name</label><br>
                <select class="soflow" name="groupID" id="groupname" required>
                    <option value selected=""><font color="gray">Select...</font></option>
                    <?php foreach($stamts AS $group) { ?>
                        <option value="<?php echo $group['groupID'] ?>"><?php echo $group['groupname'] ?></option>
                    <?php } ?>
                </select>
                <label>Subgroup Name</label><br>
                <input type="text" name="subgroupname" class="longinput" placeholder="Subgroup Name" required>
            </div>
            <div class="bottom">
                <button id="left" type="button" onclick="document.getElementById('subgroups').style.display='none'" class="btn" style="float:left">Cancel</button>
                <button id="right" class="btn" type="submit" name="addsubgroup" style="float:right">Add Subgroup</button>
            </div>
        </form>
    </div>
    <footer><h5>Copyright stocki© 2019</h5></footer>
</body>
</html>