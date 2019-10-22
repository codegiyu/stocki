<?php 
    session_start();
	include '../includes/connect.php';
	$email = $_SESSION['email'];

	if(isset($_POST['newphoto'])){

		$img = $_FILES['photo']['name'];
		$stmt = $conn->prepare("SELECT staff.email AS email, staffprofile.staffID AS staffID, staffprofile.staffname AS staffname, staffprofile.photo AS photo, COUNT(*) AS numrows FROM staff JOIN staffprofile ON staff.staffID = staffprofile.staffID WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch();

        $staffID = $row['staffID'];
        if(!empty($img)){
        $ext = pathinfo($img, PATHINFO_EXTENSION);
        $newImg = 'Updated'.time();
        move_uploaded_file($_FILES['photo']['tmp_name'], '../img/'.$newImg);	
        }
        else{
            $newImg = '';
        }
        try{
        $stmt = $conn->prepare("UPDATE staffprofile SET photo=:photo WHERE staffID=:staffID");
        $stmt->execute(['photo'=>$newImg, 'staffID'=>$staffID]);
        $_SESSION['success'] = 'Updated Successfully';
        header('location: updateprofile.php');
        }
        catch(PDOException $e){
            $_SESSION['error'] = $e->getMessage();
            header('location: updateprofile.php');
        }
	}
?>