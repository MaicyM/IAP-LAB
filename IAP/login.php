<?php

include_once "DBConnector.php";
include_once "User.php";

$con=new DBConnect;

if(isset($_POST['btn-login'])){
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	$instance=User::create();
	$instance->setPassword($password);
	$instance->setUsername($username);

	//Success
	if($instance->isPasswordCorrect()){
		$instance->login(); 	//Access Private_Page.php
		$con->closeDatabase();
		$instance->createUserSession();

		//Failed Scenario
	}else{
		$con->closeDatabase();

		header("Location: login.php");
	}
}

?>

<html>
<head>
	<title>Login Details</title>
</head>
<body>
	<form method="post" name="login" id="login" action="<?=$_SERVER['PHP_SELF'] ?>">
	<table align="center">
		<tr>
			<td><input type="text" name="username" placeholder="Username"></td>
		</tr>
		<tr>
			<td><input type="password" name="password" placeholder="Password"></td>
		</tr>
		<tr>
			<td><button type="submit" name="btn-login"><strong>Login</strong></button></td>
		</tr>
	</table>
</form>
</body>
</html>