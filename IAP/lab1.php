<?php
include_once "DBConnector.php";
include_once "User.php";
include_once "fileUploader.php";

$con=new DBConnect();

if(isset($_POST['btn-save'])){
	$first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $city=$_POST['city'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $utc_timestamp = $_POST['utc_timestamp'];
    $offset = $_POST['time_zone_offset'];

    //Initialize session to set up temporary username.
    $_SESSION['username'] = $username;

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $final_file_name = $_FILES['fileToUpload']['tmp_name'];

    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $user= new User($first_name,$last_name,$city,$username,$password);
    $user->setUtcTimestamp($utc_timestamp);
    $user->setTimezoneOffset($offset);

    $uploader = new FileUploader();

    $uploader->setUsername($username);


    $uploader->setOriginalName($file_name);
    $uploader->setFileType($file_type);
    $uploader->setFinalFileName($final_file_name);
    $uploader->setFileSize($file_size);

    if(!$user->validateForm()){
    	$user->createFormErrorSessions();
    	header("Refresh:0");
    	die();
    }
    $res=$user->save();

    //$file_upload_response = $uploader->uploadFile();

    /*if($res && $file_upload_response){
    	header("Location: login.php");
    	echo "Saved Successfully!";
    }else{
    	echo "Problem occurred. Please try again";
    }*/
}
?>
<html>
	<head>
		<title>User data</title>
		<script type="text/javascript" src="validate.js"></script>
		<sript src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></sript>
		<script type="text/javascript" src="timeZone.js"></script>
		<link rel="stylesheet" type="text/css" href="validate.css">
</head>
<body>
	<form method="POST" name="user_details" id="user_details" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?php $_SERVER['PHP_SELF']?>">
		<table align="center">
		<tr>
			<td>
				<div id="form-errors" style="color:red">
					<?php
                        session_start();
                        if(!empty($_SESSION['form_errors'])){
                        	echo" ".$_SESSION['form_errors'];
                        	unset($_SESSION['form_errors']);
                        }
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td><input type="text" name="first_name" placeholder="First Name"></td>
		</tr>
		<tr>
			<td><input type="text" name="last_name" placeholder="Last Name"></td>
		</tr>
		<tr>
			<td><input type="text" name="city" placeholder="City"></td>
		</tr>
		<tr>
			<td><input type="text" name="username" placeholder="Username"></td>
		</tr>
		<tr>
			<td><input type="password" name="password" placeholder="Password"></td>
		</tr>
		<tr>
			<td>Profile Image: <input type="file" name="fileToUpload" id="fileToUpload"></td>
		</tr>
		<tr>
			<td><button type="submit" name="btn-save"><strong>SAVE</strong></button><button type="submit" ><a href="login.php">LOGIN</a></button></td>
		</tr>
		<input type="hidden" name="utc_timestamp" id="utc_timestamp" value=""/>
		<input type="hidden" name="time_zone_offset" id="time_zone_offset" value=""/>
	</table>
</form>
</body>
</html>