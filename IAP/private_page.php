<?php

session_start();
if(!isset($_SESSION['username'])){
	header("login.php");
}

?>

<html>
<head>
	<title>Private Page</title>
</head>
<body>
	<p>This a private page</p>
	<p>We want to protect it</p>
	<p><a href="logout.php">Logout</a></p>
</body>
</html>