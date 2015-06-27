<?php 
	include_once "database.php";
	echo $db -> ifLogin();
  	$id = $_SESSION['empID'];
	
	$extDate = $_POST['dueDate'];
	$hrs = $_POST['hours'];
	$min = $_POST['minutes'];
	$en = $_POST['en'];

	$hours = $hrs * 60;
	$minutes = $min;

	$extHrs = $hours + $minutes;

	$projid = $_GET['id'];
	$id = $_GET['eid'];

	//echo $projid. ' ' . $extHrs . ' ' . $extDate;

	
	try {
		date_default_timezone_set('Asia/Manila');
					    $time = date("h:i");
					    $date = date("Y-m-d");
					    $icon = "fa fa-briefcase bg-green";
					    $query = $dbh->query("SELECT projectName as `pn` FROM project WHERE projectID = '$projid'");
					    while($row = $query->fetch()){
					    	$project = $row['pn'];
					    	$msg = "<b>".$project.'</b> has been extended.';
					    	$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
							$passval = array(null,$id,$msg,$time,$date,$icon);
							$timeline -> execute($passval);
					    }

		$query = $dbh->prepare("UPDATE project SET totalNumHours=:extHrs, duedate=:extDate, extendNo=:en WHERE projectID=:pid");
						$query -> bindParam(":extHrs",$extHrs);
						$query -> bindParam(":extDate",$extDate);
						$query -> bindParam(":pid",$projid);
						$query -> bindParam(":en",$en);
						$query -> execute();
						$snd ='174';
						$msg = "extended your project";
		               	$stat = "Unseen";
		               	$link = "projectReportOngoing2.php";
		                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		                $passval = array(null,$snd,$id,$msg,$stat,$link);
		                $notif -> execute($passval);
						echo "<script>window.location='../listProjects.php?s=e';</script>";
		
	} catch (PDOException $e) {
		
	}





?>