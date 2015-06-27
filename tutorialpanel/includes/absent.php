<?php 
	include_once "database.php";
	global $dbh;

	$tutID = $_GET['tid'];
	$d = $_POST['attdate'];
	$att = "Absent";
	
	$query = $dbh->query("SELECT empID as `eid`, studID as `sid`, session, CONCAT(s.firstName, ' ', s.lastName) as `name`
		FROM tutorial t JOIN student s ON t.studID=s.studentID WHERE tutorialID='$tutID'");

	while($row = $query->fetch()){
		$name = $row['name'];
		$insID = $row['eid'];
		$studID = $row['sid'];
		$session = $row['session'];
		$sess = $session-1;

		date_default_timezone_set('Asia/Manila');
		$date = date("Y-m-d");
		$time = date("h:i");
		$icon = "fa fa-pencil-square-o bg-red";
		$msg = '<b>'.$name. '</b> has been marked absent.';
		$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
		$passval = array(null,$insID,$msg,$time,$date,$icon);
		$timeline -> execute($passval);

		$insert_query = $dbh->prepare("INSERT INTO class(tutorialID,instID,`date`,attendance) VALUES (?,?,?,?)");
		$passval= array($tutID,$insID,$d,$att);
		$insert_query -> execute($passval);

		$update_sess = $dbh->prepare("UPDATE student SET session=? WHERE studentID=?");
		$passval2= array($sess,$studID);
		$update_sess -> execute($passval2);

		echo "<script> window.location='../tutClasses.php?s=a&st=".$name."' </script>";





	}

?>