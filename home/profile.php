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

    $stmt = $conn->prepare("SELECT staff.staffID AS staffID, staff.email AS email, staff.position AS position, staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo, staffprofile.phone AS phone, staffprofile.gender AS gender, staffprofile.dob AS dob, staffprofile.originstate AS originstate, staffprofile.lga AS lga, staffprofile.hometown AS hometown, staffprofile.maritalstatus AS maritalstatus, staffaddress.address AS address, staffaddress.area AS area, staffaddress.city AS city, staffaddress.addressstate AS addressstate FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID JOIN staffaddress ON staff.staffID = staffaddress.staffID WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();

    $right = $conn->prepare("SELECT staffprofile.staffname AS staffname, staffprofile.photo AS photo FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
    $right->execute(['email'=>$email]);
    $fetch = $right->fetch();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="css/profilestyle.css">
</head>
<body>
    <header>
        <?php include('header.php') ?>
    </header>
    <section id="top">
        <h2 class="container"><font color="#875A7B" size="6">PROFILE</font></h2>
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
    <div id="main" class="container">
        <center>
        <div id="pic">
            <img style="width:150px; height:150px" src="../img/<?php echo $fetch['photo'] ?>">
        </div>
        </center>
        <div id="profile">
            <form id="update" method="" action="">
                <table id="table">
                <tr>
                    <td class="label">
                        <p class="lab">Staff Name:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['staffname'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Staff ID:</p>
                    </td>
                    <td class="inputs">
                        <p id="number"><?php echo $row['staffID'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Position:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['position'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Email:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['email'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Phone Number:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['phone'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Gender:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['gender'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Date of Birth:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['dob'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Marital Status:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['maritalstatus'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>State of Origin:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['originstate'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>LGA:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['lga'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Hometown:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['hometown'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>House Address:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['address'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Area:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['area'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>City:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['city'] ?></p>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>State:</p>
                    </td>
                    <td class="inputs">
                        <p><?php echo $row['addressstate'] ?></p>
                    </td>
                </tr>
                </table>
                <a href="updateprofile.php"><button id="probtn" type="button">Update Profile</button></a>
            </form>
        </div>
    </div>
    <footer><h5>Copyright stocki© 2019</h5></footer>
    
        <script>
            var number = document.getElementById("number").value;
        
            console.log(number);
        </script>
</body>
</html>