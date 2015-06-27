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




		
		
		function applyLeave($id, $newstart, $newend, $dateSent, $reason, $affirm, $type){
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
				
				$rcv = "174";
                $msg = "applied for leave";
                $stat = "Unseen";
                $link = "requests2.php";
                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$rcv,$msg,$stat,$link);
                $notif -> execute($passval);

				$query = $dbh -> prepare("INSERT INTO leaves VALUES(?,?,?,?,?,?,?,?,?,?,?);");
                $passval = array(null,$id,$newstart,$newend,$dateSent,$reason,$affirm,$type,null,null,null);
                $query -> execute($passval);
                echo "<script>window.location='applyLeave.php?s=success'</script>";

			} catch (PDOException $e) {
				echo $e->getMessage();
	        	die();
			}

		}

		function fetchLeaveReport($id) {
            global $dbh;

            try {
                $query = $dbh -> query("SELECT type, leaveID as `lid`, e.employeeID, reason, startDate as 'sdate',
                                        endDate as 'edate',affirmation,dateSent as 'ds' , dateAffirm as `da`
                                        FROM leaves l JOIN employee e 
                                        ON l.employeeid=e.employeeID
                                        WHERE e.employeeID ='$id' 
                                        ");

                $query -> setFetchMode(PDO::FETCH_ASSOC);
                while($row = $query->fetch()) {
                    $modalTitle = str_replace(' ', '', $row['lid']);
                    $declineModal = str_replace(' ', '', 'decline'.$row['lid']);

                    $reason = substr($row['reason'], 0, 150);
                    $ds = date("F d, Y",strtotime($row['ds']));
                    $st = date("F d, Y",strtotime($row['sdate']));
                    $et = date("F d, Y",strtotime($row['edate']));
                    $da = date("F d, Y",strtotime($row['da']));
                    $affirm = $row['affirmation'];
                    $da = date("F d, Y",strtotime($row['da']));

                    echo '<tr>';
                    echo '<td><a href="#'.$modalTitle.'">'.$reason.'</a></td>';
                    echo '<td>'.$st.' - '.$et.'</td>';
                    if($affirm == 0){
                        echo '<td><i>Not yet confirmed</i></td>';
                    }else{
                        echo '<td>'.$da.'</td>';
                    }
                    if($affirm == '1'){
                        echo '<td><span class="badge bg-blue">Accepted</span></td>';
                    }else if($affirm == '2'){
                        echo '<td><span class="badge bg-red">Declined</span></td>';
                    }else if($affirm == '0'){
                        echo '<td><span class="badge bg-yellow">Pending</span></td>';
                    }
                    
                    echo '</tr>';
                    echo '<div id="'.$modalTitle.'" class="modalDialog"> 
                            <div class="modal-dialog">
                                <div class="modal-header">
                                    <h4 style="text-align:center;">Message Body</h4>
                                </div>

                                <div class="modal-body">
                                    
                                    <p><b>Date Affirmation:</b>' .$da. '</p>
                                    <p><b>Start Date:</b>' .$st. ' &nbsp;&nbsp;&nbsp;<b>End Date:</b>' .$et. '</p>
                                    <p><b>Leave Type:</b>' .$row['type']. '</p>
                                    <p><b>Reason:<br></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .$row['reason']. '</p>


                                    <div style="text-align:center;">


                                        <a href="#'. $declineModal .'"><button type="submit" button class="btn btn-danger" style=" margin-top:10px; float:left;">
                                            Delete
                                        </button></a>

                                        <div class="modal-footer" style="margin-top:20px;">
                                            <a href="#close"><button class="btn btn-default" style=" margin-top:-10px;"">Close</button></a>
                                        </div>
                                    </div>
                                </div>
                          </div>
                        </div>


                        <div id="'.$declineModal.'" class="modalDialog">
                            <div class="modal-dialog">
                                <div class="modal-header">
                                    <p><b>Leave Type:</b>' .$row['type']. '</p>
                                
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete?</p>
                                
                                </div>

                                <div class="modal-footer">
                                    <a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>
                                    <a href="leaveReports.php?id='.$row["lid"].'"><button class="btn btn-info">YES</button></a>
                                </div>
                            </div>
                        </div>';
            
                }
            } catch (PDOException $ex) {
                echo $ex -> getMessage();
            }
        }//leaveReports

function deleteLeaves($lid){
	global $dbh;
	$delete = $lid;
	try{
		$query = $dbh->prepare('DELETE FROM leaves WHERE leaveID=?');
		$query -> bindParam(1,$delete);
		$query -> execute();
		echo "<script>window.location='leaveReports.php?s=d'</script>";
	}catch(PDOException $ex){
		echo $ex->getMessage();
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
        $query = $dbh -> prepare('SELECT b.firstName AS `fn` , a.notifID AS  `id` , a.sender AS  `sndr` , a.reciever AS  `rcvr` , a.msg AS  `msg` , a.status, a.link AS `link` 
        FROM notification a
        INNER JOIN employee b ON a.sender = b.employeeID
        WHERE a.status =  "Unseen"
        AND a.reciever = :id
        ORDER BY a.notifID DESC');
        $query2 = $dbh -> prepare('SELECT COUNT( a.notifID ) AS  `count`
        FROM notification a
        INNER JOIN employee b ON a.reciever = b.employeeID
        WHERE a.status =  "Unseen"
        AND a.reciever = :id
        ORDER BY a.notifID DESC');

        try{
                $query-> bindParam(':id',$id);
                $query -> execute();
                $query2-> bindParam(':id',$id);
                $query2 -> execute();
                $row2 = $query2 ->fetch();
                $temp = 1;

                if($row2["count"] == 0){
                              echo "</a>
                              <ul class='dropdown-menu'>
                              <li class='header'>You have ".$row2["count"]." notifications</li>
                              <li>
                              <ul class='menu'>";
                              $temp = 2;
                }else{}

                while($row = $query -> fetch()){
                        if($temp == 1){
                        	if($row2["count"] == 0){
	                          echo "</a>
			                  <ul class='dropdown-menu'>
			                  <li class='header'>You have ".$row2["count"]." notifications</li>
			                  <li>
			                  <ul class='menu'><li>
                      		  <a href='".$row['link']."?nt=".$row['id']."'>
                      		  <i class='ion ion-ios7-people info'></i>".$row["fn"]."&nbsp;&nbsp; ".$row["msg"]."</a>
                      		  </li>";
            				  $temp = 2;
            				}elseif($row2["count"] > 0){
            				  echo "<span class='label label-warning'>".$row2["count"]."</span></a>
			                  <ul class='dropdown-menu'>
			                  <li class='header'>You have ".$row2["count"]." notifications</li>
			                  <li>
			                  <ul class='menu'>
			                  <li>
                      		  <a href='".$row['link']."?nt=".$row['id']."'>
                      		  <i class='ion ion-ios7-people info'></i>".$row["fn"]."&nbsp;&nbsp; ".$row["msg"]."</a>
                      		  </li>";
            				  $temp = 2;
            				}else{

            				}
                        }elseif($temp > 1){
                            echo "<li>
                      		<a href=".$row['link']."?nt=".$row['id']."'>
                      		<i class='ion ion-ios7-people info'></i>".$row["fn"]."&nbsp;&nbsp; ".$row["msg"]."</a>
                      		</li>";
                        }else{
                                echo "<script>alert('may mali')</script>";
                        }

            }
        }catch(PDOException $ex){

        }
}

function editProfileTimeline($id,$msg,$ctime,$date,$icon){
            global $dbh;
            try{
                $query = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$msg,$ctime,$date,$icon);
                $query -> execute($passval);
            }catch (PDOException $e) {
    
            }
        }








		










	}// class MySQLDB

$db = new MySQLDB;

?>