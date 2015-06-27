<?php
	include_once "database.php";
	global $dbh;
	$lid = $_GET['id'];
					try {
						$query = $dbh->prepare("DELETE leaves SET WHERE leaveID=:lid");
						$query -> bindParam(":lid",$lid);
						$query -> execute();
						echo "<script>window.location='leaveReports.php';</script>";
					} catch (PDOException $e) {
						
					}
				
 ?>