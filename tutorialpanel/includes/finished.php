<?php 
	include_once "database.php";
	echo $db -> ifLogin();
     $id = $_SESSION['empID']; 
	global $dbh;

	$tid = $_GET['tid'];
	$stat = "finished";
	
	$date = date("Y-m-d");
	date_default_timezone_set('Asia/Manila');
	$time = date("h:i");
	$icon = "fa fa-check bg-green";

try{
	$query = $dbh->query("SELECT CONCAT(firstName,' ',lastName) as `name`, skillName as `sn` 
		FROM tutorial t JOIN student s ON t.studID = s.studentID
		JOIN skills sk ON sk.skillID = t.classID 
		WHERE tutorialID='$tid'");

	while($row = $query->fetch()){
		$name = $row['name'];
		$class = $row['sn'];

		$msg = '<b>'.$name.'</b> has finished the required session for the class <b>'.$class.'</b>.';

		$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
		$passval = array(null,$id,$msg,$time,$date,$icon);
		$timeline -> execute($passval);
	}

	$query = $dbh->prepare("UPDATE tutorial SET status=? WHERE tutorialID=?");
	$passval= array($stat,$tid);
	$query -> execute($passval);

	$query2 = $dbh->query("SELECT studID as `sid` FROM tutorial WHERE tutorialID = '$tid'");
		while($row2 = $query2->fetch()){
							
			$sid = $row2['sid'];
			$val = 1;
			$val2 = null;
			$query = $dbh->prepare("UPDATE schedule SET availability=:av, studID=:sid, classID=:cid, classsched=:cs WHERE employeeID=:eid AND studID=:sd");
			$query->bindParam(':av',$val);
			$query->bindParam(':sid',$val2);
			$query->bindParam(':cid',$val2);
			$query->bindParam(':cs',$val2);
			$query->bindParam(':eid',$id);
			$query->bindParam(':sd',$sid);
			$query->execute();
							
		}
			$snd ='174';
			$msg = "has finished a class";
		    $stat = "Unseen";
			$link = "tutorReport2.php";
		    $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		    $passval = array(null,$id,$snd,$msg,$stat,$link);
		    $notif -> execute($passval);
		echo "<script> window.location='../tutClasses.php?dd=".$sid."&s=f&st=".$name."' </script>";

	
	}catch(PDOException $e){

	}

?>