<?php
	include_once "database.php";
	echo $db -> ifLogin();
  	$id = $_SESSION['empID'];
	global $dbh;
	$pid = $_GET['id'];
	$rcv = $_GET['eid'];
	$stat = "finished";
	$en = $_POST['en'];

					try {
						date_default_timezone_set('Asia/Manila');
					    $time = date("h:i");
					    $date = date("Y-m-d");
					    $icon = "fa fa-check bg-green";
					    $query = $dbh->query("SELECT projectName as `pn` FROM project WHERE projectID = '$pid'");
					    while($row = $query->fetch()){
					    	$project = $row['pn'];
					    	$msg = "<b>".$project.'</b> has been finished.';
					    	$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
							$passval = array(null,$id,$msg,$time,$date,$icon);
							$timeline -> execute($passval);
						}

						$query = $dbh->prepare("UPDATE project SET status=:stat, totalNumHours = '0', finishNo=:en WHERE projectID=:pid");
						$query -> bindParam(":stat",$stat);
						$query -> bindParam(":pid",$pid);
						$query -> bindParam(":en",$en);
						$query -> execute();
						$snd ='174';
						$msg = "has finished the project";
		               	$stat = "Unseen";
						$link = "projectReportFinished2.php";
		                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		                $passval = array(null,$snd,$rcv,$msg,$stat,$link);
		                $notif -> execute($passval);
						echo "<script>window.location='../listProjects.php?s=f';</script>";
					} catch (PDOException $e) {
						
					}
				
 ?>