<?php
	include_once "database.php";
	echo $db -> ifLogin();
	$id = $_SESSION['empID'];
	global $dbh;



					try {
						$query = $dbh->prepare("DELETE FROM timeline");

						$query -> execute();
						echo "<script>window.location='../timeline.php?s=cleared';</script>";
					} catch (PDOException $e) {
						
					}
					
 ?>