<?php
session_start();
include("../includes/connect.php");
if(!$_SESSION['email']){
    $_SESSION['error'] = 'You must login to access this page!';
    header("location:../login.php");
}
$email = $_SESSION['email'];
$staffemail = $_GET['email'];
    $stmt = $conn->prepare("SELECT * FROM staffprofile JOIN staff ON staffprofile.staffID = staff.staffID");
    $stmt->execute(['email'=>$email]);

    $stm = $conn->prepare("SELECT staff.staffID AS staffID, staff.email AS email, staff.position AS position, staff.role AS role FROM staff WHERE email = :email");
    $stm->execute(['email'=>$staffemail]);
    $rows = $stm->fetch();

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
    <link rel="stylesheet" type="text/css" href="css/positionstyle.css">
    <script src="js/viewstaff.js" type="text/javascript"></script>
</head>
<body>
    <header>
        <?php include('header.php') ?>
    </header>
    <section class="main">
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
        <div id="modal" class="modal">
            <form class="modal-content animate" method="POST" action="updatepos.php">
                <!-- <center> -->
                <div class="container1">
                    <input type="text" id="email" name="email" value="<?php echo $staffemail ?>" readonly>
                    <label>Current Position</label><br>
                    <input type="text" class="inputgroup" name="position" value="<?php echo $rows['position'] ?>" readonly><br>
                    <label>New Position</label><br>
                    <input type="text" class="inputgroup" name="newposition" placeholder="Please Enter New Position" required>
                </div>
                <div class="bottom">
                    <!-- <button id="left" type="button" onclick="document.getElementById('modal').style.display='none'" class="btn" style="float:left">Cancel</button> -->
                    <button id="right" class="btn" type="submit" name="changeposition" style="float:right">Update</button>
                </div>
                <!-- </center> -->
            </form>
        </div>
    </section>
    <footer><h5>Copyright stocki© 2019</h5></footer>
</body>
</html>