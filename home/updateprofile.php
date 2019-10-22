<?php
session_start();
include("../includes/connect.php");
if(!$_SESSION['email']){
    $_SESSION['error'] = 'You must login to access this page!';
    header("location:../login.php");
}
$email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT staff.staffID AS staffID, staff.email AS email, staff.position AS position, staff.role AS role, staff.status AS status, staffprofile.staffname AS staffname, staffprofile.photo AS photo, staffprofile.phone AS phone, staffprofile.gender AS gender, staffprofile.dob AS dob, staffprofile.originstate AS originstate, staffprofile.lga AS lga, staffprofile.hometown AS hometown, staffprofile.maritalstatus AS maritalstatus, staffaddress.address AS address, staffaddress.area AS area, staffaddress.city AS city, staffaddress.addressstate AS addressstate FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID JOIN staffaddress ON staff.staffID = staffaddress.staffID WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();

    $right = $conn->prepare("SELECT staff.role AS role, staffprofile.staffname AS staffname, staffprofile.photo AS photo FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
    $right->execute(['email'=>$email]);
    $fetch = $right->fetch();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Profile</title>
    <link rel="stylesheet" type="text/css" href="css/profilestyle.css">
    <script src="js/lgaselect.js" type="text/javascript"></script>
    <script src="js/profile.js" type="text/javascript"></script>
</head>
<body>
    <header>
        <?php include('header.php') ?>
    </header>
    <section id="top">
        <h2 class="container"><font color="#875A7B" size="6">UPDATE PROFILE</font></h2>
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
        <center>
            <button id="changephoto" onclick="document.getElementById('modal').style.display='block'">Change Photo</button> 
        </center>
        <div id="profile">
            <form id="update" method="POST" action="processupdate.php">
                <table id="table">
                <tr>
                    <td class="label">
                        <p class="lab">Staff Name:</p>
                    </td>
                    <td class="inputs">
                        <input type="text" class="inputgroup" name="staffname" value="<?php echo $row['staffname'] ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Staff ID:</p>
                    </td>
                    <td class="inputs">
                        <input type="number" class="inputgroup" placeholder="<?php echo $row['staffID'] ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Position:</p>
                    </td>
                    <td class="inputs">
                        <input type="text" class="inputgroup" name="position" placeholder="<?php echo $row['position'] ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Email:</p>
                    </td>
                    <td class="inputs">
                        <input type="email" class="inputgroup" name="email" placeholder="<?php echo $row['email'] ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Phone Number:</p>
                    </td>
                    <td class="inputs">
                        <input type="text" class="inputgroup" name="phone" placeholder="Phone Number" value="<?php echo $row['phone'] ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Gender:</p>
                    </td>
                    <td class="inputs">
                        <select class="soflow" name="gender" id="gender" required>
                            <option value selected="selected">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Date of Birth:</p>
                    </td>
                    <td class="inputs">
                        <input type="date" class="inputgroup" name="dob" value="<?php echo $row['dob'] ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Marital Status:</p>
                    </td>
                    <td class="inputs">
                        <select class="soflow" name="maritalstatus" id="ms" required>
                            <option value selected="selected">Select</option>
                            <option value="Married">Married</option>
                            <option value="Single">Single</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Separated">Separated</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Others">Others</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>State of Origin:</p>
                    </td>
                    <td class="inputs">
                        <select class="soflow" name="originstate" id="states" onclick="getLgas()" required>
                            <option value selected="selected">Select State</option>
                            <option value="Abia">Abia</option>
                            <option value="Adamawa">Adamawa</option>
                            <option value="Akwa-Ibom">Akwa-Ibom</option>
                            <option value="Anambra">Anambra</option>
                            <option value="Bauchi">Bauchi</option>
                            <option value="Bayelsa">Bayelsa</option>
                            <option value="Benue">Benue</option>
                            <option value="Borno">Borno</option>
                            <option value="Cross River">Cross River</option>
                            <option value="Delta">Delta</option>
                            <option value="Ebonyi">Ebonyi</option>
                            <option value="Edo">Edo</option>
                            <option value="Ekiti">Ekiti</option>
                            <option value="Enugu">Enugu</option>
                            <option value="Gombe">Gombe</option>
                            <option value="Imo">Imo</option>
                            <option value="Jigawa">Jigawa</option>
                            <option value="Kaduna">Kaduna</option>
                            <option value="Kano">Kano</option>
                            <option value="Katsina">Katsina</option>
                            <option value="Kebbi">Kebbi</option>
                            <option value="Kogi">Kogi</option>
                            <option value="Kwara">Kwara</option>
                            <option value="Lagos">Lagos</option>
                            <option value="Nassarawa">Nassarawa</option>
                            <option value="Niger">Niger</option>
                            <option value="Ogun">Ogun</option>
                            <option value="Ondo">Ondo</option>
                            <option value="Osun">Osun</option>
                            <option value="Oyo">Oyo</option>
                            <option value="Plateau">Plateau</option>
                            <option value="Rivers">Rivers</option>
                            <option value="Sokoto">Sokoto</option>
                            <option value="Taraba">Taraba</option>
                            <option value="Yobe">Yobe</option>
                            <option value="Zamfara">Zamfara</option>
                            <option value="FCT">FCT</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>LGA:</p>
                    </td>
                    <td class="inputs">
                        <select class="soflow" id="lgas" name="lga" required>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Hometown:</p>
                    </td>
                    <td class="inputs">
                        <input type="text" class="inputgroup" name="hometown" value="<?php echo $row['hometown'] ?>" placeholder="Hometown" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>House Address:</p>
                    </td>
                    <td class="inputs">
                        <input type="text" class="inputgroup" name="address" value="<?php echo $row['address'] ?>" placeholder="Address" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>Area:</p>
                    </td>
                    <td class="inputs">
                        <input type="text" class="inputgroup" name="area" value="<?php echo $row['area'] ?>" placeholder="Area of Town" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>City:</p>
                    </td>
                    <td class="inputs">
                        <input type="text" class="inputgroup" name="city" value="<?php echo $row['city'] ?>" placeholder="City of Residence" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <p>State:</p>
                    </td>
                    <td class="inputs">
                        <select class="soflow" name="addressstate" id="" required>
                            <option value selected="selected">Select</option>
                            <option value="Abia">Abia</option>
                            <option value="Adamawa">Adamawa</option>
                            <option value="Akwa-Ibom">Akwa-Ibom</option>
                            <option value="Anambra">Anambra</option>
                            <option value="Bauchi">Bauchi</option>
                            <option value="Bayelsa">Bayelsa</option>
                            <option value="Benue">Benue</option>
                            <option value="Borno">Borno</option>
                            <option value="Cross River">Cross River</option>
                            <option value="Delta">Delta</option>
                            <option value="Ebonyi">Ebonyi</option>
                            <option value="Edo">Edo</option>
                            <option value="EKiti">Ekiti</option>
                            <option value="Enugu">Enugu</option>
                            <option value="Gombe">Gombe</option>
                            <option value="Imo">Imo</option>
                            <option value="Jigawa">Jigawa</option>
                            <option value="Kaduna">Kaduna</option>
                            <option value="Kano">Kano</option>
                            <option value="Katsina">Katsina</option>
                            <option value="Kebbi">Kebbi</option>
                            <option value="Kogi">Kogi</option>
                            <option value="Kwara">Kwara</option>
                            <option value="Lagos">Lagos</option>
                            <option value="Nassarawa">Nassarawa</option>
                            <option value="Niger">Niger</option>
                            <option value="Ogun">Ogun</option>
                            <option value="Ondo">Ondo</option>
                            <option value="Osun">Osun</option>
                            <option value="Oyo">Oyo</option>
                            <option value="Plateau">Plateau</option>
                            <option value="Rivers">Rivers</option>
                            <option value="Sokoto">Sokoto</option>
                            <option value="Taraba">Taraba</option>
                            <option value="Yobe">Yobe</option>
                            <option value="Zamfara">Zamfara</option>
                            <option value="FCT">FCT</option>
                        </select>
                    </td>
                </tr>
                </table>
                <a href="profile.php"><button id="probtn2" type="button">Back To Profile</button></a>
                <button id="probtn" type="submit" name="update">Update Profile</button>
            </form>
        </div>
    </div>
    <div id="modal" class="modal">
        <form class="modal-content animate" method="POST" action="changephoto.php" enctype="multipart/form-data">
            <div class="imgcontainer">
                <span onclick="document.getElementById('modal').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>
            <div class="container1">
                <p><i>Please select an image file less than 8mb</i></p>
                <input class="btn1" type="file" value="choose" name="photo" required>
            </div>
            <div class="bottom">
                <button id="left" type="button" onclick="document.getElementById('modal').style.display='none'" class="btn" style="float:left">Cancel</button>
                <button id="right" class="btn" type="submit" name="newphoto" style="float:right">Upload</button>
            </div>
        </form>
    </div>
    <footer><h5>Copyright stocki© 2019</h5></footer>
</body>
</html>