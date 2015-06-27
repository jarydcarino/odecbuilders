<?php 
	include("constants.php");

	
	class MySQLDB {
		function MySQLDB(){
			global $dbh;

			try{
				$dbh = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.'',DB_USER,DB_PASS);
	       		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        	$dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

			}catch(PDOException $e){
				echo $e->getMessage();
	        	die();
			}
		}// function MySQLDB


		function editProfile($first, $last, $address, $email, $bday, $pic, $contact, $username, $password, $empid){
			global $dbh;

			try {
				$query = $dbh->prepare("UPDATE employee SET firstName=:first, lastName=:last, 
					address=:address, email=:email, contactNum=:contact,
					bday=:bday, picture=:pic 
					WHERE employeeID=:empid;");
				$query -> bindParam(":first", $first);
				$query -> bindParam(":last", $last);
				$query -> bindParam(":address", $address);
				$query -> bindParam(":email", $email);
				$query -> bindParam(":bday", $bday);
				$query -> bindParam(":contact", $contact);
				$query -> bindParam(":empid", $empid);

				if( ($_FILES['picture']['error'] > 0) || 
        			($_FILES['picture']['type'] != 'image/jpeg') && ($_FILES['picture']['type'] != 'image/png') && ($_FILES['picture']['type'] != 'image/gif') ||
         			($_FILES['picture']['size'] > 5242880)){
          			$query -> bindParam(':pic',$pic);        			

    			}else{
				      $split = explode('.',$_FILES['picture']['name']);
				      $extension = $split[1];
				      $newname = $empid;
				      $path = '../adminpanel/img/users/'.$newname.'.'.$extension;
				      $query -> bindParam(':pic',$path);
				      move_uploaded_file($_FILES['picture']['tmp_name'], $path);			     
		    	}

				$query -> execute();
				$this->updateAccount($empid,$username,$password);
				 echo "<script>window.location='tutProfile.php?s=updated'</script>";

			} catch (PDOException $e) {
				echo $e->getMessage();
	        	die();	
			}
		}




		
		function applyLeave($id, $newstart, $newend, $remarks, $affirm, $type, $status){
			global $dbh;

			try {
				date_default_timezone_set('Asia/Manila');
				$time = date("h:i");
				$date = date("Y-m-d");
				$icon = "fa fa-plus-square bg-red";
				$msg = '<b>LEAVE APPLICATION:</b> '.$remarks;
				$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
				$passval = array(null,$id,$msg,$time,$date,$icon);
				$timeline -> execute($passval);

				$query = $dbh -> prepare("INSERT INTO leaves VALUES(?,?,?,?,?,?,?,?);");
				$passval = array(null,$id,$newstart,$newend,$remarks,$affirm,$type,$status);
				$query -> execute($passval);
				echo "<script>window.location='applyLeave.php?s=success'</script>";

			} catch (PDOException $e) {
				echo $e->getMessage();
	        	die();
			}

		}

		function viewClass($id){
			global $dbh;

			$query = $dbh->query("SELECT se.skillID as 'sid', s.skillName as 'sn' FROM `employee` e 
									JOIN skillemp se ON e.employeeID=se.empID
									JOIN skills s ON s.skillID = se.skillID
									WHERE employeeID = '$id' AND skillType='class'");
			while($row = $query->fetch() ){
				echo "<option value='".$row['sid']."'>".$row["sn"]."</option>";
			}
		}

		function showStudents($id,$subject){
			global $dbh;
		    try{
		        $query = $dbh -> query("SELECT * FROM
										(SELECT
										CONCAT(s.firstName,' ', s.lastName) as `name`,
										s.className as `cn`, 
										ss.studID as `sid`,
										GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`, 
										GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`,
										c.remainingSessions as `rs`, 
										ss.status as `status`
										FROM student s
										JOIN employee e ON e.employeeID = s.instID
										JOIN class c ON c.instID = s.instID
										JOIN schedstudent ss ON ss.studID = s.studentID
										WHERE status = '1' AND s.instID = '$id' AND s.className = '$subject'
										GROUP BY `studID`) as `tablename`" ); 
		        while($row = $query -> fetch()){
		        	echo '<tr>';
		        	echo '<td>'.$row['sid'].'</td>';
		        	echo '<td>'.$row['name'].'</td>';
		        	echo '<td>'.$row['schedule'].'</td>';
		        	echo '<td>'.$row['time'].'</td>';
		        	echo '<td>'.$row['rs'].'</td>';
		        	echo '</tr>';
		        }
		    	
		    }catch(PDOException $ex){

		    }

		}



		

		function updateAccount($empid,$username,$password){
			global $dbh;

			$query = $dbh->prepare("UPDATE account SET username=?, password=? WHERE empID=?");
			$passval = array($username,$password,$empid);
			$query->execute($passval);
		}









		function ifLogin(){
    		session_start();
      		if(!isset($_SESSION['type']))
      		{
      			echo '<script>windows: location="../login.php";</script>';
      		}
  		}//iflogin



  		function fetchnotif($id){
	global $dbh;
	$query = $dbh -> prepare('SELECT COUNT( a.notifID ) AS  `count` , a.notifID AS  `id` , a.sender AS  `sndr` , a.reciever AS  `rcvr` , a.msg AS  `msg` , a.status 
FROM notification a
INNER JOIN employee b ON a.reciever = b.employeeID
WHERE a.status =  "Unseen"
AND a.reciever = :id
ORDER BY a.notifID DESC');
	try{
		$query-> bindParam(':id',$id);
		$query -> execute();
		$temp = 1;
		while($row = $query -> fetch()){
			if($temp == 1){
			echo "<span class='label label-warning'>".$row["count"]."</span></a>
                  <ul class='dropdown-menu'>
                  <li class='header'>You have ".$row["count"]." notifications</li>
                  <li>
                  <ul class='menu'>
                  <li>
                  <a href='#'>
                  <i class='ion ion-ios7-people info'></i>".$row["sndr"]."&nbsp;&nbsp; ".$row["msg"]."</a>
                  </li>";
            $temp = 2;
			}elseif($temp > 1){
				echo "<li>
                      <a href='#'>
                      <i class='ion ion-ios7-people info'></i>".$row["sndr"]."&nbsp;&nbsp; ".$row["msg"]."</a>
                      </li>";
			}else{
				echo "<script>alert('may mali')</script>";
			}

			}
	}catch(PDOException $ex){

	}
}




		










	}// class MySQLDB

$db = new MySQLDB;

?>