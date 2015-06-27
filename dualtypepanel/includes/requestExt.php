<?php 
	include_once "database.php";
	echo $db -> ifLogin();
  	$id = $_SESSION['empID'];

	
	try {
				
				$rcv = "174";
                $msg = "requested for extension";
                $stat = "Unseen";
                $link = "listProjects2.php";
                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$rcv,$msg,$stat,$link);
                $notif -> execute($passval);

                echo "<script>window.location='../projects.php?s=ext'</script>";
				
			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}





?>