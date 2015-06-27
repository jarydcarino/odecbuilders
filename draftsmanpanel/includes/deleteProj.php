<?php
	include_once "database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            $pid = $_GET['pid'];
	date_default_timezone_set('Asia/Manila');
    $time = date("h:i");
    $date = date("Y-m-d");
    $icon = "fa fa-trash-o bg-red";
	try{
	
	$query = $dbh->query("SELECT projectName as `pn` FROM project WHERE projectID='$pid'");
	while($row = $query->fetch()){
		$msg = $row['pn']." project has been deleted.";
		$timeline = $dbh-> prepare("INSERT INTO timeline VALUES(?,?,?,?,?,?)");
		$passval = array(null,$id,$msg,$time,$date,$icon);
		$timeline->execute($passval);
	}
		$query = $dbh->prepare('DELETE FROM projwork WHERE proj_id=?');
		$query -> bindParam(1,$pid);
		$query -> execute();

		$query = $dbh->prepare('DELETE FROM project WHERE projectID=?');
		$query -> bindParam(1,$pid);
		$query -> execute();


		echo "<script>window.location='../projectReport.php?s=d'</script>";
	}catch(PDOException $ex){
		echo $ex->getMessage();
		die();
	}
	?>