<?php include_once "database.php";
	echo $db -> ifLogin();
     $id = $_SESSION['empID']; 

	$q = $_GET['q']; 

	if($q=="class"){
		echo '<input type="hidden" name="type" value="class"';
		echo '<label for="numberSessions" style="float:left;"><i class="fa fa-clock-o"></i> Number of Sessions</label>
              <input name="numberSessions" class="form-control" placeholder="eg. 18" type="number" required/>';
	}elseif($q=="skill"){
		$sess = 0;
		echo '<input type="hidden" name="numberSessions" value='.$sess.'>'	;
	}else{
		$sess = 0;
		echo '<input type="hidden" name="numberSessions" value='.$sess.'>'	;
	}
?>

