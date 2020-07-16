<?php

include_once "User.php";
$instance=User::create();
$instance->logout();
//header("Location: lab1.php");


?>