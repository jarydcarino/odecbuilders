<?php
include_once "includes/database.php";

  if(isset($_POST['usernames'])){

	$users = $_POST['usernames'];
	$passs = $_POST['passwords'];
  
	echo $db->checkLogins($users,$passs);
  } 
?>