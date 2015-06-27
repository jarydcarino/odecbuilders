<?php
	include_once "database.php";
	 echo $db -> ifLogin();
  	$id = $_SESSION['empID'];

	global $dbh;
	$pid = $_GET['tid'];
	$stat = "dropped";
					try {
						date_default_timezone_set('Asia/Manila');
					    $time = date("h:i");
					    $date = date("Y-m-d");
					    $icon = "fa fa-book bg-red";

						$query = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `name` FROM  tutorial t JOIN student s ON t.studID=s.studentID WHERE tutorialID = '$pid'");
						while($row = $query->fetch()){
							$name = $row['name'];
							$msg = '<b>'.$name.'</b> dropped his class.';
							$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
							$passval = array(null,$id,$msg,$time,$date,$icon);
							$timeline -> execute($passval);
						}

						$query = $dbh->prepare("UPDATE tutorial SET status=:stat WHERE tutorialID=:pid");
						$query -> bindParam(":stat",$stat);
						$query -> bindParam(":pid",$pid);
						$query -> execute();

						$query2 = $dbh->query("SELECT studID as `sid` FROM tutorial WHERE tutorialID = '$pid'");
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
						$msg = "has dropped a classcard";
		    			$stat = "Unseen";
						$link = "classReportDropped2.php";
		    			$notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		    			$passval = array(null,$id,$snd,$msg,$stat,$link);
		    			$notif -> execute($passval);
						echo "<script> window.location='../tutClasses.php?dd=".$sid."&s=d&st=".$name."' </script>";
						
					} catch (PDOException $e) {
						
					}
				
 ?>