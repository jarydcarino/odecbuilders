<?php
	include_once "database.php";
	echo $db -> ifLogin();
	$id = $_SESSION['empID'];
	global $dbh;
	$lid = $_GET['id'];
	$eid = $_GET['eid'];
	$stat = "1";

	$remarks = $_POST['remarks'];
	$en = $_POST['en'];

	date_default_timezone_set('Asia/Manila');
		    $da = date("Y-m-d");

					try {
						$query = $dbh->prepare("UPDATE leaves SET affirmation=:stat, remarks=:remarks, entryNo=:en, dateAffirm=:da WHERE leaveID=:lid");
						$query -> bindParam(":stat",$stat);
						$query -> bindParam(":lid",$lid);
						$query -> bindParam(":remarks",$remarks);
						$query -> bindParam(":en",$en);
						$query -> bindParam(":da",$da);
						$query -> execute();
						$snd ='174';
						$msg = "accepted your leave request";
		               	$stat = "Unseen";
						$link = "leaveReports2.php";
		                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		                $passval = array(null,$snd,$eid,$msg,$stat,$link);
		                $notif -> execute($passval);
						echo "<script>window.location='../leaveReportsAccepted.php?s=accepted';</script>";
					} catch (PDOException $e) {
						
					}
					
 ?>