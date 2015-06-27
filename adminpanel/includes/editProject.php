<?php 
	include_once "database.php";
	echo $db -> ifLogin();
  	$id = $_SESSION['empID'];
	



	$projid = $_GET['id'];
	$id = $_GET['eid'];

	$pn = $_POST['title'];
	$client = $_POST['client'];
	$contact = $_POST['contact'];
	$location = $_POST['location'];

	
	try {
		date_default_timezone_set('Asia/Manila');
					    $time = date("h:i");
					    $date = date("Y-m-d");
					    $icon = "fa fa-briefcase bg-green";
					    $query = $dbh->query("SELECT projectName as `pn` FROM project WHERE projectID = '$projid'");
					    while($row = $query->fetch()){
					    	$project = $row['pn'];
					    	$msg = "<b>".$project.'</b> has been edited.';
					    	$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
							$passval = array(null,$id,$msg,$time,$date,$icon);
							$timeline -> execute($passval);
					    }

		$query = $dbh->prepare("UPDATE project SET projectName=:pn, clientName=:client, contactNum=:contact, location=:location WHERE projectID=:pid");
						$query -> bindParam(":pn",$pn);
						$query -> bindParam(":client",$client);
						$query -> bindParam(":contact",$contact);
						$query -> bindParam(":location",$location);
						$query -> bindParam(":pid",$projid);
						$query -> execute();
						$snd ='174';
						$msg = "the project is edited";
		               	$stat = "Unseen";
		               	$link = "projectReportOngoing2.php";
		                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		                $passval = array(null,$snd,$id,$msg,$stat,$link);
		                $notif -> execute($passval);
						echo "<script>window.location='../listProjects.php?s=d';</script>";
		
	} catch (PDOException $e) {
		
	}





?>