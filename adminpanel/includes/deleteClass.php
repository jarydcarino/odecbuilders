<?php 
	include_once "database.php";
	echo $db -> ifLogin();
  	$id = $_SESSION['empID'];
  	$tid = $_GET['tid'];
  	$eid = $_GET['eid'];

  	$query2 = $dbh->query("SELECT studID as `sid`, CONCAT(firstName,' ', lastName) as `name`  FROM tutorial t JOIN student s ON t.studID=s.studentID WHERE tutorialID = '$tid'");
						while($row2 = $query2->fetch()){

							date_default_timezone_set('Asia/Manila');
						    $time = date("h:i");
						    $date = date("Y-m-d");
						    $icon = "fa fa-times bg-red";
							
							$sid = $row2['sid'];

							
								$name = $row2['name']."'s";
								$msg = '<b>'.$name.'</b> class has been deleted.';
								$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
								$passval = array(null,$id,$msg,$time,$date,$icon);
								$timeline -> execute($passval);
						

							$val = 1;
							$val2 = null;
							$query = $dbh->prepare("UPDATE schedule SET availability=:av, studID=:sid, classID=:cid, classsched=:cs WHERE employeeID=:eid AND studID=:sd");
							$query->bindParam(':av',$val);
							$query->bindParam(':sid',$val2);
							$query->bindParam(':cid',$val2);
							$query->bindParam(':cs',$val2);
							$query->bindParam(':eid',$eid);
							$query->bindParam(':sd',$sid);
							$query->execute();



							$query = $dbh->prepare("DELETE FROM student WHERE studentID=:student");
							$query->bindParam(':student',$sid);
							$query->execute();

							
							
							echo "<script>window.location='../listOfClasses.php?s=del';</script>";
							
						}

?>