<?php
	include_once "database.php";
	global $dbh;
	$pid = $_GET['id'];
	$rcv = $_GET['eid'];
	$stat = "cancelled";
	$remarks = $_POST['remarks'];
	$en = $_POST['en'];
					try {
						$query = $dbh->prepare("UPDATE project SET status=:stat, totalNumHours= '0', remarks=:remarks, cancelNo=:en WHERE projectID=:pid");
						$query -> bindParam(":stat",$stat);
						$query -> bindParam(":remarks",$remarks);
						$query -> bindParam(":pid",$pid);
						$query -> bindParam(":en",$en);
						$query -> execute();
						echo "<script>window.location='../listProjects.php?s=x';</script>";
						$snd ='174';
						$msg = "has cancelled a project";
		               	$stat = "Unseen";
						$link = "projectReportCancelled2.php";
		                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		                $passval = array(null,$snd,$rcv,$msg,$stat,$link);
		                $notif -> execute($passval);
					} catch (PDOException $e) {
						
					}
				
 ?>