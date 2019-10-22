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

$stm = $conn->prepare("SELECT staff.staffID AS staffID, staff.email AS email, staff.position AS position, staff.role AS role, staff.status AS status, staff.employ_status, staffprofile.staffname AS staffname, staffprofile.photo AS photo, staffprofile.phone AS phone, staffprofile.gender AS gender, staffprofile.dob AS dob, staffprofile.originstate AS originstate, staffprofile.lga AS lga, staffprofile.hometown AS hometown, staffprofile.maritalstatus AS maritalstatus, staffaddress.address AS address, staffaddress.area AS area, staffaddress.city AS city, staffaddress.addressstate AS addressstate FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID JOIN staffaddress ON staff.staffID = staffaddress.staffID WHERE employ_status != 'Discontinued' ORDER BY staffID ASC");
$stm->execute();
// $rows = $stm->fetch();

$right = $conn->prepare("SELECT staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
$right->execute(['email'=>$email]);
$fetch = $right->fetch();

if($fetch['role'] != 'Admin'){
    $_SESSION['error'] = 'You must be an admin to access this page!';
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Staff</title>
    <link rel="stylesheet" type="text/css" href="css/vsstyle.css">
    <script src="js/viewstaff.js" type="text/javascript"></script>
</head>
<body>
    <header>
        <?php include('header.php') ?>
    </header>
    <section id="top">
        <table class="container" id="table2" border="0" width="100%">
            <col style="width:30%">
            <col style="width:70%">
            <thead>
                <th><h2><font color="rgb(122, 29, 98)" size="6">View Staff Records</font></h2></th>
                <th>
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
                </th>
            </thead>
        </table>
    </section>
    <section class="main">
        <table id="table" border="0" width="100%">
            <col style="width:5%">
            <col style="width:18%">
            <col style="width:20%">
            <col style="width:15%">
            <col style="width:12%">
            <col style="width:10%">
            <col style="width:10%">
            <col style="width:10%">
            <thead>
            <tr id="first">
                <th>ID</th>
                <th>Staff Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Role</th>
                <th>Status</th>                    
                <th>View</th>                    
                <th>Terminate</th>                    
            </tr>
            </thead>
            <tbody>
            <?php foreach($stm AS $rows) { ?>
                <tr>
                    <td><?php echo $rows['staffID'] ?></td>
                    <td><?php echo $rows['staffname'] ?></td>
                    <td><?php echo $rows['email'] ?></td>
                    <td>
                        <?php echo $rows['position'] ?>
                        <a class="change" id="changeposition" href="changeposition.php?email=<?php echo $rows['email'] ?>"><font size="1">Change</font></a>
                    </td>
                    <td>
                        <?php echo $rows['role'] ?>
                        <?php if ($rows['role'] == 'Admin'){ ?>
                            <a class="change" href="makestaff.php?email=<?php echo $rows['email'] ?>" onclick="return confirm('Are you sure you want to change role to Staff?')"><font size="1">Change</font></a>
                        <?php }else if ($rows['role'] == 'Staff'){ ?>
                            <a class="change" href="makeadmin.php?email=<?php echo $rows['email'] ?>" onclick="return confirm('Are you sure you want to change role to Admin?')"><font size="1">Change</font></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($rows['status'] == 1){ ?>
                            <a href="deactivate.php?email=<?php echo $rows['email'] ?>" onclick="return confirm('Are you sure you want to deactivate this staff?')">Deactivate</a>
                        <?php
                        }else if($rows['status'] == 0){ ?>
                            <a href="activate.php?email=<?php echo $rows['email'] ?>" onclick="return confirm('Are you sure you want to activate this staff?')">Activate</a>
                        <?php  } ?>
                    </td>
                    <td><a href="viewprofile.php?email=<?php echo $rows['email'] ?>">View Profile</td>
                    <td><a href="terminatestaff.php?email=<?php echo $rows['email'] ?>" onclick="return confirm('Are you sure you want to delete this staff?')">Terminate</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>
    <footer><h5>Copyright stocki© 2019</h5></footer>
</body>
</html>