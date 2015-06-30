	<?php 

include("constants.php");

class MySQLDB
{ 

/*************** ->database */
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
   }
/*************** database; */

/*************LOGIN**************/
function checkLogins($users,$passs){
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM account WHERE BINARY username=? AND BINARY password=?");
    $query->execute(array($users,$passs));
    if($query->rowCount()){
    session_start();  
          while($r = $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)){
              $queryUser = $r[0];
              $queryType = $r[3];

          }
          $_SESSION['empID'] =  $queryUser;
           $_SESSION['type'] =  $queryType;

          if ($_SESSION['type'] == "admin" || $_SESSION['type'] == "Admin")
          {
            
            $query = $dbh->prepare("SELECT type FROM account WHERE type=? ");
            
                echo '<script>windows: location="adminpanel/index.php"</script>';
          
          }
          else if ($_SESSION['type'] == "draftsman" || $_SESSION['type'] == "Draftsman")
          {
            
            $query = $dbh->prepare("SELECT type FROM account WHERE type=? ");

                echo '<script>windows: location="draftsmanpanel/index.php"</script>';
          
          }
            else if ($_SESSION['type'] == "tutorial" || $_SESSION['type'] == "Tutorial")
          {
            $query = $dbh->prepare("SELECT type FROM account WHERE type=? ");

                echo '<script>windows: location="tutorialpanel/index.php"</script>';
          }
          	else if ($_SESSION['type'] == "Draftsman/Tutor" || $_SESSION['type'] == "draftsman/tutor")
          {
            $query = $dbh->prepare("SELECT type FROM account WHERE type=? ");

                echo '<script>windows: location="dualtypepanel/index.php"</script>';
          }

    }
     elseif(empty($users) && empty($passs)){
           echo '<script>windows: location="invalidLogin.php";</script>';
     }
     elseif(empty($users)){
           echo '<script>windows: location="invalidLogin.php";</script>';
     }
     elseif(empty($passs)){
      echo '<script>windows: location="invalidLogin.php";</script>';
    }
       else{
        echo '<script>windows: location="invalidLogin.php";</script>';
     }  


    
  }

  function ifLogin(){
    session_start();
      if(!isset($_SESSION['type']))
      {
      echo '<script>windows: location="../login.php";</script>';
      }
  }


/************END LOGIN**************/

/************CHECK USERNAME************/
	function checkUser($user){
		global $dbh;
    	try {
			$query = $dbh -> query("SELECT * FROM account WHERE username='".$user."'");
			if ($query->rowCount() > 0) {
				echo "<script>alert('Username already exists!')</script>";
			}
    	} catch (PDOException $ex) {
				echo $ex -> getMessage();
		}
	}

/************INSERT**************/
		function addEmployee($fname, $lname, $contact, $address, $email, $birthdate ,$availabletime ,$pic, $user ,$pass ,$type){
			global $dbh;
			try{
				$query = $dbh -> prepare("INSERT INTO employee(firstName,lastName,contactNum,address,email,bday,availabletime,picture) VALUES (:fname,:lname,:contact,:address,:email,:birthdate, :availabletime, :pic)");
				$query -> bindParam(':fname',$fname);
				$query -> bindParam(':lname',$lname);
				$query -> bindParam(':contact',$contact);
				$query -> bindParam(':address',$address);
				$query -> bindParam(':email',$email);
				$query -> bindParam(':birthdate',$birthdate);
				$query -> bindParam(':availabletime',$availabletime);

				if( ($_FILES['picture']['error'] > 0) || 
        			($_FILES['picture']['type'] != 'image/jpeg') && ($_FILES['picture']['type'] != 'image/png') && ($_FILES['picture']['type'] != 'image/gif') ||
         			($_FILES['picture']['size'] > 5242880)){
          			$query -> bindParam(':pic',$pic);
    			}else{
				      $split = explode('.',$_FILES['picture']['name']);
				      $extension = $split[1];
				      $newname = $lname;
				      $path = '../adminpanel/img/users/'.$newname.'.'.$extension;
				      $query -> bindParam(':pic',$path);
				      move_uploaded_file($_FILES['picture']['tmp_name'], $path);		    	}

				$query -> execute();
				$empid = $dbh->lastInsertId();
				$GLOBALS['empid'] = $dbh->lastInsertId();

				$query = $dbh -> prepare("INSERT INTO account(empID,username,password,type) VALUES (:empid, :username, :password, :type)");
				$query -> bindParam(':empid',$empid);
				$query -> bindParam(':username',$user);
				$query -> bindParam(':password',$pass);
				$query -> bindParam(':type',$type);
				$query -> execute();

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}

		}//addEmployee

		function insertSchedule($day,$time,$availability){
			global $dbh; 

			try {

				$empid = $GLOBALS['empid'];
				$query = $dbh -> prepare("INSERT INTO schedule(employeeId,day,time,availability) VALUES (:empid, :day, :time, :availability)");
				$query -> bindParam(':empid',$empid);
				$query -> bindParam(':day',$day);
				$query -> bindParam(':time',$time);
				$query -> bindParam(':availability',$availability);
				$query -> execute();
				
			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}
			
		}

		function insertSkill($skill){
			global $dbh;

			try{
				$empid = $GLOBALS['empid'];
				$query = $dbh -> prepare("INSERT INTO skillemp(empID,skillID) VALUES (:empid, :skill)");
				$query -> bindParam(':empid',$empid);
				$query -> bindParam(':skill',$skill);				
				$query -> execute();

			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}
		}

		function addSkill($skName,$noSess,$type,$stat){
			global $dbh;

			try{
				$query = $dbh -> prepare("INSERT INTO skills(skillName,skillType,session,stat) VALUES (:skName,:type,:noSess,:stat)");
				$query -> bindParam(':skName',$skName);
				$query -> bindParam(':noSess',$noSess);
				$query -> bindParam(':type',$type);
				$query -> bindParam(':stat',$stat);
				$query -> execute();
		        echo "<script> window.location='contentManagement.php?s=success' </script>";

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}

		}


		function addProject($projTitle,$name,$phone,$projLoc,$hoursInMin,$skill,$sDate,$dDate,$status,$time,$date,$id,$msg,$icon){
		    global $dbh;
		    $remarks = " ";
		    $query= $dbh->prepare("INSERT INTO project VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		    $query2=$dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
		    $passval= array(null,null,$projTitle,$name,$phone,$projLoc,$hoursInMin,$skill,$sDate,$dDate,$status,$remarks,null,null,null,null,null);
		    $passval2=array(null,$id,$msg,$time,$date,$icon);
		      try{
		        $query->execute($passval);
		    	//$query2->execute($passval2);    
		        echo "<script> window.location='assignDraftsmans.php?' </script>";

		        die();
		      }catch(PDOException $ex){
		        echo $ex->getMessage();
		        die();
		      }
		  }//addproject

		  function assignStudents($fname,$lname,$email,$cnumber,$numSession,$classID,$tutor,$id){
		    global $dbh;
		    
		      try{

		      	$query = $dbh -> prepare("INSERT INTO student(firstName,lastName,email,contact,session,classID,instID) VALUES (:firstName, :lastName, :email, :contact, :session, :className, :instID)");
		        $query -> bindParam(':firstName',$fname);
		        $query -> bindParam(':lastName',$lname);
		        $query -> bindParam(':email',$email);
		        $query -> bindParam(':contact',$cnumber);
		        $query -> bindParam(':session',$numSession);
		        $query -> bindParam(':className',$classID);
		        $query -> bindParam(':instID',$tutor);
				$query -> execute();

				$studID = $dbh->lastInsertId();
				$GLOBALS['studID'] = $dbh->lastInsertId();
				$status = 'ongoing';
				$query = $dbh -> prepare("INSERT INTO tutorial(empID,studID,classID,status) VALUES (:empID,:studID,:className,:status)");
		        $query -> bindParam(':className',$classID);
		        $query -> bindParam(':empID',$tutor);
		        $query -> bindParam(':studID',$studID);
		        $query -> bindParam(':status',$status);
				$query -> execute();

                $msg = "assigned you to a student";
                $stat = "Unseen";
                $link = "tutClasses2.php";
                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$tutor,$msg,$stat,$link);
                $notif -> execute($passval);


				$this->studentTimeline($id,$tutor,$fname,$lname,$classID);
		        echo "<script>window.location='listOfClasses.php?s=add'</script>";

		      }catch(PDOException $ex){
		        echo $ex->getMessage();
		      }
		  }//assignStudents

		function insertStudentSched($empID,$classID,$day,$time,$status){
			global $dbh; 
			try {

				$studID = $GLOBALS['studID'];
				$query = $dbh -> prepare("UPDATE schedule SET studID = :studID, classID = :classID, classsched = :status 
										  WHERE day=:day AND employeeID=:empID AND time=:time ");
				$query -> bindParam(':studID',$studID);
				$query -> bindParam(':classID',$classID);
				$query -> bindParam(':empID',$empID);
				$query -> bindParam(':day',$day);
				$query -> bindParam(':time',$time);
				$query -> bindParam(':status',$status);
				$query -> execute();
				
			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}

		}

		function editStudentSched($status,$stud,$class,$day,$empid,$time) {
			global $dbh;

			try{
            	$n = $_GET['n'];
            	$class= $_GET['c'];
				$query = $dbh -> prepare("UPDATE schedule SET classsched=:status, studID=:s, classID = :classID WHERE day = :day AND employeeID = :empID AND time = :time;");
				$query -> bindParam(':status',$status);
				$query -> bindParam(':s',$stud);
				$query -> bindParam(':classID',$class);
				$query -> bindParam(':day',$day);
				$query -> bindParam(':empID',$empid);
				$query -> bindParam(':time',$time);
				$query -> execute();

				echo "<script>window.location='listOfClasses.php?s=sub'</script>";

			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}
		}

		function assignProjects(){
			global $dbh;
			

			try{
				/*$query = $dbh->query("SELECT * FROM project p 
					JOIN client c ON p.clientID = c.clientID
					JOIN employee e ON p.employeeID = e.employeeID;");*/
				$query = $dbh->query("SELECT projectName as `pn`, draftsmanID, projectID as `pid`,
									clientName as `client`, 
									location, skillReq, s.skillName as skill, startdate, duedate,
									totalNumHours as `due`, contactNum as `contact`
									FROM project p JOIN skills s ON p.skillReq=s.skillID
									WHERE `draftsmanID` is null ORDER BY startdate;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);

				

				while($row = $query->fetch()){
					$modalTitle = str_replace(' ', '', $row['pn']);
					$modalDel = str_replace(' ', '', $row['pid']);
					$edit = str_replace(' ', '', 'edit'.$row['pid']);

					$pid = $row['pid'];

					$s = date("F d, Y",strtotime($row['startdate']));
					$d = date("F d, Y",strtotime($row['duedate']));
					$hours = floor($row['due'] / 60);
    				$minutes = ($row['due'] % 60);
					echo '<tr>';
					echo '<td><b>'.$row['pn'].'</b></td>';
					echo '<td><i>'.$row['client'].'</i></td>';
					echo '<td>'.$row['skill'].'</td>';
					echo '<td>'.$s.'</td>';
					echo '<td>'.$d.'</td>';
					echo '<td>'.$hours.' hrs</td>';
					echo '<td><a href=#' . $modalTitle .'><button class="btn-primary btn-sm" style="width:70%;" type="submit" value="Find Available Draftsman"><span class="glyphicon glyphicon-search"></span>&nbsp;Find Available Draftsman</button></a>
					<a href="editProject.php?id='.$pid.'"><button class="btn btn-success btn-sm" style="width:13%;" type="submit"><span class="glyphicon glyphicon-edit"></span></button></a>
							<a href=#' . $modalDel .'> <button class="btn btn-danger btn-sm" style="width:13%;" type="submit"><i class="fa fa-fw fa-trash-o" style="text-align:left;"></i></button></a></td>';
					echo '</tr>';
					//MODAL

					echo '<div id="'.$modalTitle.'" class="modalDialog">
							<div class="modal-dialog">
								       				
                				<div class="modal-header">
						          <a href="#close" title="Close" class="close">x</a>
						          <h3 style="text-align:center;"><b>Assign Draftsman to the Project<br> " ' .$row['pn']. ' " ?</b></h3>
						        </div><br>
				                
				                <div class="modal-body">

					                <h4><b>Location: </b>'.$row['location'].'</h4>
					                <h4><b>Time for Completion:</b> '.$hours.' hrs</h4>
					                <h4><b>Due Date:</b> '.$d.'</h4>
					                <h4><b>Skill Required:</b> '.$row['skill'].'</h4>
								</div>
				                
				                <div class="modal-footer">
						          	<a href="#close"><button class="btn btn-default">CANCEL</button></a>
						          	<a href="assignToProject.php?id='.$row['pid'].'&at='.$hours.'"><button class="btn btn-success" type="submit">GO</button></a>
				                </div>
				            </div>
				        </div>

				    	<div id="' . $modalDel .'" class="modalDialog">
							<div style="width:25%; height:150px;">
						          
                				<div class="modal-body">
                					<h4>Are you sure you want to remove project?</h4>
						          
						        </div>

						        <div class="modal-footer">
						        	<a href="assignDraftsman.php?id='.$row['pid'].'"><button class="btn btn-info" type="submit">YES</button></a>
						          	<a href="#close"><button class="btn btn-danger">NO</button></a>
				                </div>
				                
				        
				            </div>
				        </div>

				        <div id="'.$edit.'" class="modalDialog" style="margin-top:-50px">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['pn']. '</h2>
                				</div>

                				<div class="modal-body">
				               		
					                <div style="text-align:left;">
					                	<h4><b>Edit Project</b></h4>
					                <form action="includes/editProjects.php?id='.$row['pid'].'" method="POST">
					                	<label><i class="fa fa-flag"></i> Project Title:</label>
					                	<input name="title" class="form-control" placeholder="Enter Title" type="text" value="'.$row['pn'].'" required/>
					                	<label><i class="fa fa-user"></i> Client:</label>
					                	<input name="client" class="form-control" type="text" placeholder="First Name, Last Name" value="'.$row['client'].'" required/>
					                	<label><i class="fa fa-mobile-phone"></i> Contact:</label>
					                	<input name="contact" class="form-control" placeholder="eg. 09xxxxxxxxx" type="text" maxlength="11" value="'.$row['contact'].'" required/>
					                	<label><i class="fa fa-map-marker"></i> Location:</label>
					                	<input name="location" class="form-control" placeholder="Location" type="text" value="'.$row['location'].'" required/>
				                
				                </div>

				                <div class="modal-footer">
				                	    <button class="btn btn-info" type="submit">DONE</button>
				                	</form>
				                	<a href=#close><button class="btn btn-default">BACK</button></a>

				                </div>
				            </div>
				        </div>';
				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}//assignProjects

/************END OF INSERT**************/

/************DELETE**************/

function deleteProject($pid,$id){
	global $dbh;
	$delete = $pid;
	date_default_timezone_set('Asia/Manila');
    $time = date("h:i");
    $date = date("Y-m-d");
    $icon = "fa fa-trash-o bg-red";

	try{
	
	$query = $dbh->query("SELECT projectName as `pn` FROM project WHERE projectID='$delete'");
	while($row = $query->fetch()){
		$msg = $row['pn']." project has been deleted.";
		$timeline = $dbh-> prepare("INSERT INTO timeline VALUES(?,?,?,?,?,?)");
		$passval = array(null,$id,$msg,$time,$date,$icon);
		$timeline->execute($passval);
	}
	
		$query = $dbh->prepare('DELETE FROM project WHERE projectID=?');
		$query -> bindParam(1,$delete);
		$query -> execute();
		echo "<script>window.location='assignDraftsman.php?s=d'</script>";
	}catch(PDOException $ex){
		echo $ex->getMessage();
		die();
	}
}

function deleteInquiry($inqid){
	global $dbh;
	$delete = $inqid;
	try{
		$query = $dbh->prepare('DELETE FROM inquiries WHERE inqid=?');
		$query -> bindParam(1,$delete);
		$query -> execute();
		echo "<script>window.location='inquiries.php?s=delete'</script>";
	}catch(PDOException $ex){
		echo $ex->getMessage();
		die();
	}
}

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


function deleteEmployee($pid,$id) {
	global $dbh;
	$delete = $pid;
	try {
		$this->deleteEmployeeTimeline($delete,$id);
		
		/*$query = $dbh -> prepare('DELETE FROM schedule WHERE employeeID=?');
		$query -> bindParam(1,$delete);
		$query -> execute();

		$query = $dbh -> prepare('DELETE FROM skillemp WHERE empID=?');
		$query -> bindParam(1,$delete);
		$query -> execute();

		$query = $dbh -> prepare('DELETE FROM account WHERE empID=?');
		$query -> bindParam(1,$delete);
		$query -> execute();*/

		$query = $dbh -> prepare('DELETE FROM employee WHERE employeeID=?');
		$query -> bindParam(1,$delete);
		$query -> execute();

		
		
		echo "<script>window.location='listOfEmployees.php?s=success'</script>";
	} catch(PDOException $ex) {
		echo $ex -> getMessage();
	}
}

function availableDraftsmen(){
	global $dbh;
	$id = $_GET['id'];
	$aa = $_GET['at'];
	try {

		$query2 = $dbh->query("SELECT startdate as `sd`, duedate as `dd` FROM project WHERE projectID ='$id'");		
		$yah = $query2 -> fetch();
			
			$current = strtotime($yah['sd']);
			$last = strtotime($yah['dd']);
			$output_format = 'Y-m-d';
			$step = '+1 day';
			$availabletime = 0;
			$classes = 0;

			$sd = $yah['sd'];
			$dd = $yah['dd'];

			$s = date("F d, Y",strtotime($sd));
			$d = date("F d, Y",strtotime($dd));



			while( $current <= $last ) {
        		$dates[] = date($output_format, $current);
 	       		$current = strtotime($step, $current);
 	   		}	



			$query = $dbh->query("SELECT a.empID as `eid`, picture, CONCAT(e.firstName,' ', e.lastName) as `draftsman`, GROUP_CONCAT(s.skillName, ' ') as `sn`						
								FROM employee e 
								JOIN account a ON e.employeeID = a.empID
                                JOIN skillemp se ON se.empID = a.empID
                                JOIN skills s ON s.skillID = se.skillID
                                WHERE a.type = 'Draftsman' OR a.type ='Draftsman/Tutor'
								GROUP BY `draftsman`");
			$query -> setFetchMode(PDO::FETCH_ASSOC);





			while($row = $query->fetch()){

			$query3 = $dbh->query("SELECT projectName as `pn`, projectID as `pid`, totalNumHours as `th` 
									FROM project WHERE projectID = $id ");
			$row2 = $query3 -> fetch();

			$temp = $row['eid'];

			$query4 = $dbh->query("SELECT picture as `pic`,firstName as `fn`, lastName as `ln`, lastName, startdate as `sd`, duedate as `dd`, (IFNULL(SUM(totalNumHours),0)) as `tt`, status
			  FROM project p JOIN employee e ON p.draftsmanID = e.employeeID WHERE draftsmanID = '$temp' AND status = 'ongoing' GROUP BY totalNumHours");
			$row4 = $query4 -> fetch();

			$tt = $row4['tt'] / 60;
			$startdate = $row4['sd'];
			$duedate = $row4['dd'];

	    	foreach($dates as $days){
    				$timestamp = strtotime($days);
   		 			$date = date('l', $timestamp);

   		 			switch($date){
   		 				case "Monday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Tuesday";
     	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Wednesday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Thursday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Friday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Saturday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Sunday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp'  AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;

   		 			}

   		 			switch($date){
   		 				case "Monday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Tuesday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Wednesday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Thursday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Friday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Saturday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Sunday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;

   		 			}

   	 		}

   	 		$total = round($availabletime - $tt - $classes);
   	 		$total2 = round($availabletime - $classes);

   	 		

   	 		$total3 = round($tt + $classes);
   	 		if($duedate >= $sd && $startdate <= $sd){
	   	 		if($total >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-info" type="submit">Assign</button></a></td>';
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="assignToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$s.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$total3.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Availability within the date: <b> '.$total.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}

			}else if($startdate >= $sd && $duedate <= $dd){
	   	 		if($total >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-info" type="submit">Assign</button></a></td>';					
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="assignToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$s.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$total3.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}
			
			}else if($startdate >= $sd && $startdate <= $dd && $duedate >= $dd){
	   	 		if($total >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-info" type="submit">Assign</button></a></td>';
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="assignToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$s.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$total3.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}
			
			}else if($sd >= $startdate){
				if($total2 >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total2;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total2.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total2.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-info" type="submit">Assign</button></a></td>';					
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="assignToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$s.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$classes.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total2.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}

			}else if($startdate >= $dd){
				if($total2 >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total2;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total2.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total2.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-info" type="submit">Assign</button></a></td>';					
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="assignToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$s.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$classes.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total2.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}

			}


 	 		

			

		}

	} catch (PDOException $ex) {
		echo $ex->getMessage();
		die();
	}
}


function subDraftsman(){
	global $dbh;
	$id = $_GET['id'];
	$aa = $_GET['at'];
	try {

		$query2 = $dbh->query("SELECT startdate as `sd`, duedate as `dd` FROM project WHERE projectID ='$id'");		
		$yah = $query2 -> fetch();
		date_default_timezone_set("Asia/Manila");
			$st = date("Y-m-d");
			$current = strtotime($st);
			$last = strtotime($yah['dd']);
			$output_format = 'Y-m-d';
			$step = '+1 day';
			$availabletime = 0;
			$classes = 0;

			$sd = $yah['sd'];
			$dd = $yah['dd'];

			$s = date("F d, Y",strtotime($sd));
			$d = date("F d, Y",strtotime($dd));

			$start = date("F d, Y",strtotime($st));


			while( $current <= $last ) {
        		$dates[] = date($output_format, $current);
 	       		$current = strtotime($step, $current);
 	   		}	



			$query = $dbh->query("SELECT a.empID as `eid`, picture, CONCAT(e.firstName,' ', e.lastName) as `draftsman`, GROUP_CONCAT(s.skillName, ' ') as `sn`						
								FROM employee e 
								JOIN account a ON e.employeeID = a.empID
                                JOIN skillemp se ON se.empID = a.empID
                                JOIN skills s ON s.skillID = se.skillID
                                WHERE a.type = 'Draftsman' OR a.type ='Draftsman/Tutor'
								GROUP BY `draftsman`");
			$query -> setFetchMode(PDO::FETCH_ASSOC);





			while($row = $query->fetch()){

			$query3 = $dbh->query("SELECT projectName as `pn`, projectID as `pid`, totalNumHours as `th` 
									FROM project WHERE projectID = $id ");
			$row2 = $query3 -> fetch();

			$temp = $row['eid'];

			$query4 = $dbh->query("SELECT picture as `pic`,firstName as `fn`, lastName as `ln`, lastName, startdate as `sd`, duedate as `dd`, (IFNULL(SUM(totalNumHours),0)) as `tt`, status
			  FROM project p JOIN employee e ON p.draftsmanID = e.employeeID WHERE draftsmanID = '$temp' AND status = 'ongoing' GROUP BY totalNumHours");
			$row4 = $query4 -> fetch();

			$tt = $row4['tt'] / 60;
			$startdate = $row4['sd'];
			$duedate = $row4['dd'];

	    	foreach($dates as $days){
    				$timestamp = strtotime($days);
   		 			$date = date('l', $timestamp);

   		 			switch($date){
   		 				case "Monday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Tuesday";
     	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Wednesday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Thursday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Friday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Saturday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;
   		 				case "Sunday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(availability) as `av` FROM schedule 
   	 								WHERE availability = 1 AND employeeID = '$temp'  AND day = '$date' ");
   	 						$emp = $search -> fetch();
   		 					$availabletime = $availabletime + $emp['av'];
   		 					break;

   		 			}

   		 			switch($date){
   		 				case "Monday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Tuesday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Wednesday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Thursday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Friday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Saturday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;
   		 				case "Sunday";
    	 					$search = $dbh ->query("SELECT employeeID, day, COUNT(classsched) as `cs` FROM schedule 
   	 								WHERE classsched = 1 AND employeeID = '$temp' AND day = '$date' ");
   	 						$emp2 = $search -> fetch();
   		 					$classes = $classes + $emp2['cs'];
   		 					break;

   		 			}

   	 		}

   	 		$total = round($availabletime - $tt - $classes);
   	 		$total2 = round($availabletime - $classes);

   	 		$total3 = round($tt + $classes);
   	 		if($duedate >= $start && $startdate <= $start){
	   	 		if($total >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-warning" type="submit">Substitute</button></a></td>';
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="subToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$s.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$total3.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}

			}else if($startdate >= $start && $duedate <= $dd){
	   	 		if($total >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-warning" type="submit">Substitute</button></a></td>';				
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="subToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$s.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$total3.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}
			
			}else if($startdate >= $start && $startdate <= $dd && $duedate >= $dd){
	   	 		if($total >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-warning" type="submit">Substitute</button></a></td>';
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="subToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$s.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$total3.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}
			
			}else if($start >= $startdate){
				if($total2 >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total2;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total2.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total2.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-warning" type="submit">Substitute</button></a></td>';					
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="subToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$start.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$classes.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total2.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}

			}else if($startdate >= $dd){
				if($total2 >= $aa){
	   	 			$modalTitle = str_replace(' ', '', $row['draftsman']);
	   	 			$timeModal = str_replace(' ', '', $availabletime);
	   	 			$percent = $aa/$total2;
   	 				$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td><b>'.$row['draftsman'].'</b></td>';
					echo '<td style="text-align:center;"><a href=#'.$timeModal.'>'.$total2.' hours
					<div class="clearfix">
                                                    <small class="pull-right">'.$aa.'/'.$total2.' hours</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: '.$percent_friendly.'%;"></div>
                                                </div></a>
					</td>';
					echo '<td><a href=#'.$modalTitle.'><button style="width:100%" class="btn btn-warning" type="submit">Substitute</button></a></td>';					
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row2['pn'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Assign <b> '.$row['draftsman'].'</b> for the Project?</h4>
							                
										</div>
						                
						                <div class="modal-footer">
						                	<a href="subToProject.php?id='.$row2['pid'].'&eid='.$row['eid'].'&at='.$availabletime.'"><button class="btn btn-info" type="submit">YES</button></a>	
						                	<a href=#close><button class="btn btn-warning" type="submit">NO</button></a>	
						                </div>
						            </div>
					</div>';
					echo '<div id="'.$timeModal.'" class="modalDialog">
									<div class="modal-dialog">
										       				
		                				<div class="modal-header">
								          <a href="#close" title="Close" class="close">x</a>
								           <h3 style="text-align:center;"><b>'.$row['draftsman'].'</b></h3>
								          
								        </div><br>
						                
						                <div class="modal-body">
						                	<h4 style="text-align:center;">Start Date: <b> '.$start.'</b></h4>
						                	<h4 style="text-align:center;">Due Date: <b> '.$d.'</b></h4>
						                	<h4 style="text-align:center;">Available Time w/in the date: <b> '.$availabletime.' hours</b></h4>
						                	<h4 style="text-align:center;">Projects/Classes w/in the date: <b> '.$classes.' hours</b></h4>
						                	<h4 style="text-align:center;">-----------------------------------------------------</b></h4>
						                	<h4 style="text-align:center;">Total Hours w/in the date: <b> '.$total2.' hours</b></h4>
							                
										</div>
						                
						                <div class="modal-footer">
						            
						                	<a href=#close><button class="btn btn-default" type="submit">Close</button></a>	
						                </div>
						            </div>
					</div>';
					$availabletime = 0;
					$classes = 0;
					}

			}


 	 		

			

		}

	} catch (PDOException $ex) {
		echo $ex->getMessage();
		die();
	}
}

/************END OF DELETE**************/

/************FETCH**************/
		function fetchProjects(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT * FROM
									(SELECT projectName as `pn`, projectID as `pid`,
									clientName as `client`, skillName as `sn`,
									CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
									location, duedate,
									totalNumHours as `due`, status, employeeID as `eid`,
									p.contactNum as `contact`, p.duedate as `ddate`, p.extendNo as `exno`, p.holdNo as `hno`, p.continueNo as `cno`, p.cancelNo as `xno`, p.finishNo as `fno`
									FROM project p 
									JOIN employee e ON p.draftsmanID = e.employeeID
									JOIN skills s ON p.skillReq = s.skillID) as `tablename`
									WHERE due >0 and status='added' OR status='ongoing' OR status='hold';
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){

					$pid = $row['pid'];
					$exno = $row['exno'];
					$hno = $row['hno'];
					$cno = $row['cno'];
					$xno = $row['xno'];
					$fno = $row['fno'];


					date_default_timezone_set("Asia/Manila");
					$ddate = date("Y-m-d");
					
					$modalTitle = str_replace(' ', '', $row['pn']);
					$editModal = str_replace(' ', '', 'edit'.$row['pn']);
					$extendModal = str_replace(' ', '', 'extend'.$row['pn']);
					$holdModal = str_replace(' ', '', 'hold'.$row['pn']);
					$conModal = str_replace(' ', '', 'continue'.$row['pn']);
					$finModal = str_replace(' ', '', 'finish'.$row['pn']);
					$cancelModal = str_replace(' ', '', 'cancel'.$row['pn']);
					
					$d = date("F d, Y",strtotime($row['duedate']));
					$hours = floor($row['due'] / 60);
    				$minutes = ($row['due'] % 60);

    				$sub = $row['due'] / 60;
    				
    				$query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
									");
    				$row2 = $query2->fetch();

    				$h = floor($row2['consumed'] / 60);
    				$m = ($row2['consumed'] % 60);

					echo '<tr>';
					echo '<td><b>'.$row['pn'].'</b></td>';
					echo '<td><i>'.$row['draftsman'].'</i></td>';
					echo '<td>'.$row['client'].'</td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td>'.$d.'</td>';
					if($hours == '0' && $minutes == '0' && $row['status'] == 'onhold'){
						echo '<td><b>ON-HOLD</b></td>';
					}else{
						echo '<td><b>'.$hours.' hrs and '.$minutes.' minutes</b></td>';
					}

					if($h == '0' && $m == '0'){
						echo '<td><i>Not Yet Started</i></td>';						
					}else{
						echo '<td><a href="projLogs.php?id='.$row['pid'].'">'.$h.' hrs and '.$m.' minutes</a></td>';
					}
					
					echo '<td>'.$row['status'].'</td>';

					echo '<td><a href="#'.$modalTitle.'"><button style="width:100%" class="btn btn-warning" type="submit"><i class="fa fa-gear"></i>&nbsp;Options</button></a></td>';
					echo '</tr>';
					//MODAL


					echo '<div id="'.$modalTitle.'" class="modalDialog" style="margin-top:-50px">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['pn']. '</h2>
                				</div>

                				<div class="modal-body">';

                				if($row['ddate'] < $ddate || ($hours == 0 && $minutes == 0)){
                					echo '			<a href="substituteDraftsman.php?id='.$pid.'&at='.$sub.'"><button class="btn btn-danger btn-sm" style="width:18%; float:right;" type="submit" disabled><span class="glyphicon glyphicon-pencil"></span></button></a>';
                				}else{
                					echo '			<a href="substituteDraftsman.php?id='.$pid.'&at='.$sub.'"><button class="btn btn-danger btn-sm" style="width:18%; float:right;" type="submit"><span class="glyphicon glyphicon-pencil"></span></button></a>';
                				}
                	
                	echo '			<a href="#'.$editModal.'"><button class="btn btn-default btn-sm" style="width:18%; float:right; margin-right:5px;" type="submit"><span class="glyphicon glyphicon-edit"></span></button></a>
                					<p><b>Draftsman: </b>'.$row['draftsman'].'</p>
                					<p><b>Client: </b>'.$row['client'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
                					<p><b>Skill: </b>'.$row['sn'].'</p>
				                	<p><b>Location: </b>'.$row['location'].'</p>
				               		<p><b>Remaining Time Left:</b>'.$hours.' hrs and '.$minutes.' minutes</p>
				               		<p><b>Time Consumed:</b>'.$h.' hrs and '.$m.' minutes</p>
				                	<p><b>Due Date:</b> '.$d.'</p>
					                <div style="text-align:center;">';

					                if($row['status'] == "hold" || $row['status'] == "Hold"){
					                    
					                    echo '<a href="#'.$conModal.'"><button type="submit" class="btn btn-warning" style="width:170px; height:50px; float:left; display:block;">
								            Continue Project
								           	</button></a>';
					                    echo '<a href="#'.$cancelModal.'"><button type="submit" class="btn btn-danger" style="width:170px; height:50px; float:right;">
					                        	Cancel Project
					                    	</button></a>';
									}else{
										echo '<a href="#'.$extendModal.'"><button type="submit" class="btn btn-info" style="width:170px; height:50px; float:left; display:block;">
					                        Extend Project
					                    	</button></a>';
										echo '<a href="#'.$holdModal.'"><button type="submit" class="btn btn-warning" style="width:170px; height:50px; float:right; display:block;">
							                Hold Project
							                </button></a>';
							            echo '<a href="#'.$finModal.'"><button type="submit" class="btn btn-success" style="width:170px; height:50px; margin-top:20px;float:left;">
					                        Finish Project
					                    </button></a><br><br>';
					                    echo '<a href="#'.$cancelModal.'"><button type="submit" class="btn btn-danger" style="width:170px; height:50px; margin-top:20px; float:right;">
					                        	Cancel Project
					                    	</button></a>';

									}
					
					
					                    
	                echo '				</div>
				                
				                </div>

				                <div class="modal-footer" style="margin-top:100px;">
				                	<a href="#close"><button class="btn btn-default">CLOSE</button></a>
				                </div>
				            </div>


				        </div>';

				    echo '<div id="'.$extendModal.'" class="modalDialog" style="margin-top:-70px">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['pn']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Draftsman: </b>'.$row['draftsman'].'</p>
                					<p><b>Client: </b>'.$row['client'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
                					<p><b>Skill: </b>'.$row['sn'].'</p>
				                	<p><b>Location: </b>'.$row['location'].'</p>
				               		
					                <div style="text-align:left;">
					                	<h4><b>Extend the project</b></h4>
					                <form action="includes/extendProject.php?id='.$row['pid'].'&eid='.$row['eid'].'" method="POST">
					                	<label><span class="glyphicon glyphicon-star"></span> Entry Number: (in logbook)</label>
					                	<input style="display:inline;" type="number" class="form-control" name="en" id="entry" min="0" max="10000" placeholder="Enter a Number" pattern="\d+" value="'.$exno.'" required/>
					                	<label><i class="fa fa-calendar"></i> Due Date</label>
					                	<input style="display:inline;" type="date" class="form-control" data-mask name="dueDate" id="dueDate" min="'.$ddate.'" value="'.$row['duedate'].'" required/>
					                	
					                	<label for="hours"><i class="fa fa-clock-o"></i> Total No. of Hours for Completion</label><br>
                                        Hours<input name="hours" id="hours" class="form-control" type="number" value="'.$hours.'"" pattern="\d+" required/>
                                        Minutes<input name="minutes" id="hours" class="form-control" type="number" value="'.$minutes.'"" pattern="\d+" required/>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	    <button class="btn btn-info" type="submit">DONE</button>
				                	</form>
				                	<a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>

				                </div>
				            </div>
				        </div>';
				    
				    echo '<div id="'.$holdModal.'" class="modalDialog" style="margin-top:-50px">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['pn']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Draftsman: </b>'.$row['draftsman'].'</p>
                					<p><b>Client: </b>'.$row['client'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
                					<p><b>Skill: </b>'.$row['sn'].'</p>
				                	<p><b>Location: </b>'.$row['location'].'</p>
					                <div style="text-align:left;">
					                	<h4><b>Hold the project?</b></h4>
					                	<form action="includes/holdProject.php?id='.$row['pid'].'&eid='.$row['eid'].'" method="POST">
					                	<label><span class="glyphicon glyphicon-star"></span> Entry Number: (in logbook)</label>
					                	<input style="display:inline;" type="number" class="form-control" name="en" id="entry" pattern="\d+" min="0" max="10000" placeholder="Enter a Number" value="'.$hno.'" required/>
					                	<label>Remarks:</label>
					                	<input type="text" class="form-control" rows="5" name="remarks" placeholder="What is the reason?" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" style="height:100px;" required></input>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">				                	
				                	<button class="btn btn-info" type="submit">DONE</button>
				                	</form>
				                	<a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>
				                </div>
				            </div>
				        </div>';

				    echo '<div id="'.$conModal.'" class="modalDialog" style="margin-top:-50px">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['pn']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Draftsman: </b>'.$row['draftsman'].'</p>
                					<p><b>Client: </b>'.$row['client'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
                					<p><b>Skill: </b>'.$row['sn'].'</p>
				                	<p><b>Location: </b>'.$row['location'].'</p>
					                <div style="text-align:left;">
					                	<h4><b>Continue the project</b></h4>
					                <form action="includes/continueProject.php?id='.$row['pid'].'&eid='.$row['eid'].'" method="POST">
					                	<label><span class="glyphicon glyphicon-star"></span> Entry Number: (in logbook)</label>
					                	<input style="display:inline;" type="number" class="form-control" name="en" id="entry" pattern="\d+" min="0" max="10000" placeholder="Enter a Number" value="'.$cno.'" required/>
					                	<label><i class="fa fa-calendar"></i> Due Date</label>
					                	<input style="display:inline;" type="date" class="form-control" data-mask name="dueDate" id="dueDate"  min="'.$ddate.'" value="'.$row['duedate'].'" required/>
					                	
					                	<label for="hours"><i class="fa fa-clock-o"></i> Total No. of Hours for Completion</label><br>
                                        Hours<input name="hours" id="hours" class="form-control" type="number" value="'.$hours.'"" pattern="\d+" required/>
                                        Minutes<input name="minutes" id="hours" class="form-control" type="number" value="'.$minutes.'"" pattern="\d+" required/>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	    <button class="btn btn-info" type="submit">DONE</button>
				                	</form>
				                	<a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>

				                </div>
				            </div>
				        </div>';

				    echo '<div id="'.$finModal.'" class="modalDialog" style="margin-top:-50px">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['pn']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Draftsman: </b>'.$row['draftsman'].'</p>
                					<p><b>Client: </b>'.$row['client'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
                					<p><b>Skill: </b>'.$row['sn'].'</p>
				                	<p><b>Location: </b>'.$row['location'].'</p>
					                <div style="text-align:left;">
					                	<h4><b>Finish the project?</b></h4>
					                	<form action="includes/finishProject.php?id='.$row["pid"].'&eid='.$row['eid'].'" method="POST">
					                	<label><span class="glyphicon glyphicon-star"></span> Entry Number: (in logbook)</label>
					                	<input style="display:inline;" type="number" class="form-control" pattern="\d+" name="en" id="entry" min="0" max="10000" placeholder="Enter a Number" value="'.$fno.'" required/>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	<button class="btn btn-info" type="submit">YES</button>
				                	</form>
				                	<a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>
				                	
				                </div>
				            </div>
				        </div>';

				    echo '<div id="'.$cancelModal.'" class="modalDialog" style="margin-top:-50px">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['pn']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Draftsman: </b>'.$row['draftsman'].'</p>
                					<p><b>Client: </b>'.$row['client'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
                					<p><b>Skill: </b>'.$row['sn'].'</p>
				                	<p><b>Location: </b>'.$row['location'].'</p>
					                <div style="text-align:left;">
					                	<h4><b>Cancel the project?</b></h4>
					                	<form action="includes/cancelProject.php?id='.$row['pid'].'&eid='.$row['eid'].'" method="POST">
					                	<label><span class="glyphicon glyphicon-star"></span> Entry Number: (in logbook)</label>
					                	<input style="display:inline;" type="number" pattern="\d+" class="form-control" name="en" id="entry" pattern="\d+" min="0" max="10000" placeholder="Enter a Number" value="'.$xno.'" required/>
					                	<label>Remarks:</label>
					                	<input type="text" class="form-control" rows="5" name="remarks" placeholder="What is the reason?" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required></input>

	                				</div>

				                </div>

				                <div class="modal-footer">
				                	<button class="btn btn-info" type="submit">DONE</button>
				                	</form>
				                	<a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>
				                </div>
				            </div>
				        </div>';
				    echo '<div id="'.$editModal.'" class="modalDialog" style="margin-top:-50px">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['pn']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Draftsman: </b>'.$row['draftsman'].'</p>
				               		
					                <div style="text-align:left;">
					                	<h4><b>Edit Project</b></h4>
					                <form action="includes/editProject.php?id='.$row['pid'].'&eid='.$row['eid'].'" method="POST">
					                	<label><i class="fa fa-flag"></i> Project Title:</label>
					                	<input name="title" class="form-control" placeholder="Enter Title" type="text" value="'.$row['pn'].'" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
					                	<label><i class="fa fa-user"></i> Client:</label>
					                	<input name="client" class="form-control" type="text" placeholder="First Name, Last Name" value="'.$row['client'].'" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
					                	<label><i class="fa fa-mobile-phone"></i> Contact:</label>
					                	<input name="contact" class="form-control" placeholder="eg. 09xxxxxxxxx" type="text" maxlength="11" value="'.$row['contact'].'" pattern="(0[0-9]{10})" required/>
					                	<label><i class="fa fa-map-marker"></i> Location:</label>
					                	<input name="location" class="form-control" placeholder="Location" type="text" value="'.$row['location'].'" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
				                
				                </div>

				                <div class="modal-footer">
				                	    <button class="btn btn-info" type="submit">DONE</button>
				                	</form>
				                	<a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>

				                </div>
				            </div>
				        </div>';
				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}//fetchProjects

		function fetchTutors(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT a.empID as `eid`, picture, CONCAT(e.firstName,' ', e.lastName) as `tutor`, GROUP_CONCAT('  ',s.skillName, ' ') as `sn`						
									FROM employee e 
									JOIN account a ON e.employeeID = a.empID
                                    JOIN skillemp se ON se.empID = a.empID
                                    JOIN skills s ON s.skillID = se.skillID
                                    WHERE a.type = 'Tutorial' OR a.type='Draftsman/Tutor'
									GROUP BY `tutor`");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$modalTitle = str_replace(' ', '', $row['tutor']);
					echo '<tr>';
					echo '<td><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image" /></td>';
					echo '<td><b>'.$row['tutor'].'</b></td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td><a href="schedule2.php?id='.$row['eid'].'"><button class="btn btn-info btn-sm" style="width:40%;" type="submit"><i class="fa fa-calendar"></i></button></a>
					<a href="reportsTutor.php?eid='.$row['eid'].'&type=all"><button class="btn btn-success btn-sm" style="width:55%;"><i class="fa fa-clipboard"></i>&nbsp;Reports</button></a></td>';
					echo '</tr>';
				}
				}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}//fetchTutors

		function fetchTutors2(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT picture, CONCAT(e.firstName,' ', e.lastName) as `tutor`, GROUP_CONCAT('  ',s.skillName, ' ') as `sn`						
									FROM employee e 
									JOIN account a ON e.employeeID = a.empID
                                    JOIN skillemp se ON se.empID = a.empID
                                    JOIN skills s ON s.skillID = se.skillID
                                    WHERE a.type = 'tutorial'
									GROUP BY `tutor`");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$modalTitle = str_replace(' ', '', $row['tutor']);
					echo '<tr>';
					echo '<td><img src="img/avatar.png" class="img-square aaa" alt="User Image" /></td>';
					echo '<td>'.$row['tutor'].'</td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '</tr>';

				}
				}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}//fetchTutors2
		
		function fetchEmployees() {
			global $dbh;

			try {
				$query = $dbh -> query("SELECT * FROM
					(SELECT
						a.empID as `user`,
						picture as `picture`,
						CONCAT(e.firstName,' ',e.lastName) as `empname`,
						email as `email`,
						a.type as `type`,
						GROUP_CONCAT(DISTINCT ' ',s.skillName,' ') as `sname`
						FROM employee e
						JOIN account a ON e.employeeID = a.empID
						JOIN skillemp se ON se.empID = e.employeeID
						JOIN skills s ON s.skillID = se.skillID GROUP BY `empname` ORDER BY `empname` ASC) as `tibolnim`
				");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()) {
					$modalDel = str_replace(' ', '', $row['user']);
					$empID = $row['user'];
					echo '<tr>';

					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image" /></td>';
					echo '<td><b>'.$row['empname'].'</b></td>';
					if($row['type'] == 'Admin'){
						echo '<td><i>Administrator</i></td>';
					}else{
						echo '<td><i>'.$row['type'].'</i></td>';
					}
					echo '<td>'.$row['sname'].'</td>';

					$query2 = $dbh -> query("SELECT * FROM project WHERE draftsmanID = '$empID'");
					$row2 = $query2->fetch();
					$query3 = $dbh -> query("SELECT * FROM tutorial WHERE empID = '$empID'");
					$row3 = $query3->fetch();
					echo '<td><a href="viewProfile.php?id='.$empID.'"><button class="btn btn-info btn-sm" style="width:60%;" type="submit"><i class="fa fa-fw fa-th-large"></i>&nbsp;View Profile</button></a>
					<a href="editEmpProfile.php?id='.$empID.'"><button class="btn btn-success btn-sm" style="width:18%;" type="submit"><span class="glyphicon glyphicon-edit"></span></button></a>&nbsp;';
					if($row2 > 0 || $row3 >0){
						echo '<a href=#' . $modalDel .'><button class="btn btn-danger" style="width:18%;" type="submit" disabled><i class="fa fa-fw fa-trash-o" style="text-align:center;"></i></button></a></td>';
					}else{
						echo '<a href=#' . $modalDel .'><button class="btn btn-danger" style="width:18%;" type="submit"><i class="fa fa-fw fa-trash-o" style="text-align:center;"></i></button></a></td>';
					}
					echo '</tr>';
					
					echo '<div id="' . $modalDel .'" class="modalDialog">
							<div style="width:25%; height:150px;">
						          
                				<div class="modal-body">
                					<h4>Are you sure you want to remove employee?</h4>
						          
						        </div>

						        <div class="modal-footer">
						        	<a href="listOfEmployee.php?id='.$row['user'].'"><button class="btn btn-info" type="submit">YES</button></a>
						          	<a href="#close"><button class="btn btn-danger">NO</button></a>
				                </div>
				                
				        
				            </div>
				        </div>';
				}
			} catch (PDOException $ex) {
				echo $ex -> getMessage();
			}
		}//fetchEmployee

		function fetchDraftsman(){
			global $dbh;

			try{
				/*$query = $dbh->query("SELECT * FROM project p 
					JOIN client c ON p.clientID = c.clientID
					JOIN employee e ON p.employeeID = e.employeeID;");*/
				$query = $dbh->query("SELECT a.empID as `eid`, picture, CONCAT(e.firstName,' ', e.lastName) as `draftsman`, GROUP_CONCAT(' ',s.skillName, ' ') as `sn`						
									FROM employee e 
									JOIN account a ON e.employeeID = a.empID
                                    JOIN skillemp se ON se.empID = a.empID
                                    JOIN skills s ON s.skillID = se.skillID
                                    WHERE a.type = 'Draftsman' OR a.type ='Draftsman/Tutor'
									GROUP BY `draftsman`");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$modalTitle = str_replace(' ', '', $row['draftsman']);
					echo '<tr>';
					echo '<td><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image"  width="200px" heigh="200px"/></td>';
					echo '<td style="width:150px;"><b>'.$row['draftsman'].'</b></td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td style="width:150px;"><a href="schedule.php?id='.$row['eid'].'"><button class="btn btn-info btn-sm" style="width:40%;" type="submit"><i class="fa fa-calendar"></i></button></a>&nbsp;
					<a href=reports.php?eid='.$row['eid'].'&type=all><button style="width:55%;" class="btn btn-success btn-sm"><i class="fa fa-clipboard"></i>&nbsp;Reports</button></a></td>';
					
					echo '</tr>';


				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}//fetchDraftsman

		function fetchClasses(){
			global $dbh;
			try{
				$query = $dbh->query("SELECT
									CONCAT(s.firstName,' ', s.lastName) as `name`, s.studentID as `sid`,
									s.classID as `cn`, sk.skillName as `sn`, GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`, GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`,
									ss.classsched as `status`, s.instid as `inst`, sk.skillID as `cid`, t.tutorialID as `tid`, s.session,e.employeeID as `eid`,
									CONCAT(e.firstName,' ', e.lastName) as `tutor`,
									s.email as `email`, s.session, s.contact as `contact`
									FROM student s
									JOIN employee e ON e.employeeID = s.instID
									JOIN schedule ss ON ss.studID = s.studentID
									JOIN skills sk ON s.classID = sk.skillID
									JOIN tutorial t ON t.studID = s.studentID
									WHERE ss.classsched = '1' AND t.status = 'ongoing' AND s.session > 0
									GROUP BY t.studID
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){

					$modalTitle = str_replace(' ', '', $row['name']);
					$dropModal = str_replace(' ', '', 'dropped'.$row['name']);
					$deleteModal = str_replace(' ', '', 'del'.$row['name']);
					$status = $row['status'];
					$inst = $row['inst'];
					echo '<tr>';
					echo '<td><b>'.$row['name'].'</b></td>';
					echo '<td><i>'.$row['sn'].'</i></td>';
					
					echo '<td>'.$row['schedule'].'<br><br>'.$row['time'].'</td>';

					echo '<td style="text-align:center;"><a href="viewCCard.php?id='.$row['sid'].'&n='.$row['name'].'&c='.$row['sn'].'&i='.$inst.'&tid='.$row['tid'].'"><span class="badge bg-yellow"><i class="fa fa-fw fa-book"></i>'.$row['session'].' sessions</span></a></td>';
					echo '<td>'.$row['tutor'].'</td>';

					echo '<td><a href=#' . $modalTitle .'><button class="btn btn-danger btn-sm" style="width:100%;" type="submit" value=""><i class="fa fa-fw fa-gears"></i>Options</button></a></td>';
					echo '</tr>';

					//MODAL
					echo '<div id="'.$modalTitle.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Tutor: </b>'.$row['tutor'].'</p>
                					<p><b>Class: </b>'.$row['sn'].'</p>
                					<p><b>Email: </b>'.$row['email'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>

					                <div style="text-align:center;">
					                	<br><a href="editClassSched.php?id='.$row['sid'].'&eid='.$row['inst'].'&sid='.$row['sid'].'&n='.$row['name'].'&c='.$row['cn'].'"><button type="submit" class="btn btn-info" style="width:170px; height:50px;float:left;"><i class="fa fa-fw fa-calendar-o"></i>
					                        Edit Schedule
					                    </button></a>
					                    <a href="substitution.php?id='.$row['tid'].'&n='.$row['name'].'&c='.$row['sn'].'&i='.$inst.'&cid='.$row['cid'].'&sess='.$row['session'].'&sid='.$row['sid'].'"><button type="submit" class="btn btn-warning" style="width:170px; height:50px; float:right;"><i class="glyphicon glyphicon-check"></i>
					                        Assign Substitute
					                    </button></a>
					                    <br><a href=#' . $dropModal .'><button class="btn btn-danger btn-sm" style="width:170px; height:50px;margin-top: 10px;float:inherit;" type="submit" value=""><i class="glyphicon glyphicon-circle-arrow-down"></i>
					                    	Drop Class
					                    </button></a>
					                    <br>

	                				</div>
				                
				                </div>

				                <div class="modal-footer" style="margin-top:30px;">
				                	<a href="#close"><button class="btn btn-default">CLOSE</button></a>
				                </div>
				            </div>


				        </div>';


				        echo '<div id="'.$dropModal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
					                <div style="text-align:left;">
					                	<h4><b>Drop the Class?</b></h4>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	<a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>
				                	<a href="includes/dropclass.php?id='.$row['tid'].'&eid='.$row['inst'].'"><button class="btn btn-info">YES</button></a>
				                </div>
				            </div>
				        </div>';

				        echo '<div id="'.$deleteModal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
					                <div style="text-align:left;">
					                	<h4><b>Delete the Class?</b></h4>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	<a href=#'.$modalTitle.'><button class="btn btn-default">BACK</button></a>
				                	<a href="includes/deleteClass.php?tid='.$row['tid'].'&eid='.$row['eid'].'"><button class="btn btn-info">YES</button></a>
				                </div>
				            </div>
				        </div>';




        				
				}
				}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}//fetchClasses

	function fetchOngoingProjects(){
			global $dbh;

			try{
				$getOngoing = $dbh->query("SELECT CONCAT(e.firstName,' ', e.lastName) as `emp`, p.projectID as `pid`, e.employeeID as `eid`, p.projectName as `p`, p.status as `s`, p.totalNumHours as `due` FROM project p JOIN employee e ON e.employeeID = p.draftsmanID WHERE status='ongoing'");
				$getOngoing->execute();

				$report = $getOngoing->fetchAll();

				foreach( $report as $row) {
					$pid = $row['pid'];
					$hours = floor($row['due'] / 60);
    				$minutes = ($row['due'] % 60);

    				$query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
									");
    				$row2 = $query2->fetch();

    				$h = floor($row2['consumed'] / 60);
    				$m = ($row2['consumed'] % 60);
					$id = $row['eid'];
					echo "<tr>";
					echo "<td><b>".$row['p']."</b></td>";
		
					echo "<td><i>".$row['emp']."</i></td>";
					echo "<td>".$hours." hours and ".$minutes." minutes</td>";
					if($h == '0' && $m == '0'){
						echo '<td><i>Not Yet Started</i></td>';						
					}else{
						echo '<td><a href="projectLog3.php?pid='.$row['pid'].'&eid='.$row['eid'].'&type=ongoing">'.$h.' hrs and '.$m.' minutes</a></td>';
					}
					echo "</tr>";	
				}
			}catch(PDOExeption $ex){
				echo $ex->getMessage();
			}
		}

		function fetchEmployee(){
        	global $dbh;
            	try{
             	   $getOngoing = $dbh->query("SELECT CONCAT(e.firstName,' ', e.lastName) as `eid` FROM employee");
             	   $getOngoing->execute();
                
             	   $getOngoing ->setFetchMode(PDO::FETCH_ASSOC);
              	  while($row = $getOngoing->fetch()) { 
               		     echo $row['eid'] . "\n";
               	 }

           	 }catch (PDOException $ex){
            	    echo $ex->getMessage();
          	  }
			}




		function assign($pid,$eid,$id,$time,$date,$msg,$icon){
					global $dbh;
					try {
						$query = $dbh->prepare("UPDATE project SET draftsmanID=? WHERE projectID=?");
						$query2= $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
						$passval=array($eid,$pid);
						$passval2=array(null,$id,$msg,$time,$date,$icon);
						$query -> execute($passval);
						$query2 -> execute($passval2);
						$snd ='174';
						$msg = "has assigned you a project";
		               	$stat = "Unseen";
		               	$link = "projectReportOngoing2.php";
		                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		                $passval = array(null,$snd,$eid,$msg,$stat,$link);
		                $notif -> execute($passval);
						echo "<script>window.location='listProjects.php?s=assigned';</script>";
					} catch (PDOException $e) {
						
					}
				}

		function subDrafts($pid,$eid,$id,$time,$date,$msg,$icon,$dmid){
					global $dbh;
					try {
						$snd ='174';
						$msg = "has substitute you a project";
						$msg2 = "has your project assigned to another draftsman";
		               	$stat = "Unseen";
		               	$link = "projectReportOngoing2.php";
		               	$link2 = "index3.php";

		               	$notif1 = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		                $passval1 = array(null,$snd,$dmid,$msg2,$stat,$link2);
		                $notif1 -> execute($passval1);

						$query = $dbh->prepare("UPDATE project SET draftsmanID=? WHERE projectID=?");
						$query2= $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
						$passval=array($eid,$pid);
						$passval2=array(null,$id,$msg,$time,$date,$icon);
						$query -> execute($passval);
						$query2 -> execute($passval2);
						
		                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
		                $passval = array(null,$snd,$eid,$msg,$stat,$link);
		                $notif -> execute($passval);
						echo "<script>window.location='listProjects.php?s=a';</script>";
					} catch (PDOException $e) {
						
					}
				}

		function fetchId(){
			global $dbh;
			try{
				$getOngoing = $dbh->query("SELECT max(employeeID) as `eid` FROM employee");
				$getOngoing->execute();
			}catch (PDOException $ex){
				echo $ex->getMessage();
			}
		}





		function fetchOngoingClasses(){
			global $dbh;

			try{
				$getOngoing = $dbh->query("SELECT CONCAT(e.firstName,' ',e.lastName) as `tutor`, st.studentID as `sid`, e.employeeID as `inst`,
					CONCAT(st.firstName,' ',st.lastName) as `student`, s.skillName as `class`, st.session as `session` , t.tutorialID as `tid` 
					FROM `tutorial` t JOIN student st ON t.studID = st.studentID JOIN employee e ON e.employeeID = t.empID 
					JOIN skills s ON t.classID = s.skillID WHERE t.status= 'ongoing' 
										");
				$getOngoing->execute();

				$report = $getOngoing->fetchAll();
				
				foreach( $report as $row) {
					echo "<tr>";
					echo "<td><b>".$row['student']."</b></td>";
					echo "<td><i>".$row['class']."</i></td>";
					echo "<td>".$row['tutor']."</td>";				
					echo "<td style='text-align:center;'><a href='viewCCard3.php?id=".$row['sid']."&n=".$row['student']."&c=".$row['class']."&i=".$row['inst']."&tid=".$row['tid']."'><span class='badge bg-yellow'>".$row['session']." sessions</span></a></td>";
					echo "</tr>";	
				}
			}catch(PDOExeption $ex){
				echo $ex->getMessage();
			}
		}

		function fetchDraftsmanReport(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT DISTINCT(CONCAT(firstname,' ', lastname)) as `name`, picture, empID as `id` FROM 
									project left join account on project.draftsmanID = account.empID left join
									employee on account.empID = employee.employeeID where account.type = 'Draftsman/Tutor'
									or account.type = 'Draftsman';
									");


				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$query_finished = $dbh->query("SELECT count(*) as `finished` FROM project where  `status` = 'finished' and draftsmanID = '" .$row['id'] ."';");
					$query_ongoing = $dbh->query("SELECT count(*) as `ongoing` FROM project where  `status` = 'ongoing' and draftsmanID = '". $row['id'] ."';");
					$stat_finished = $query_finished->fetch();
					$stat_ongoing = $query_ongoing->fetch();
										

					echo '<tr>'; 
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image" /></td>';
					echo '<td><a href="dailyLogs.php?id='.$row['id'].'"><b>'.$row['name'].'</b></a></td>';
					
					if($stat_finished['finished']==0){
					echo '<td><span class="badge bg-red">'.$stat_finished['finished'].'</td>';
					}else{
						echo '<td><a href="accomplishedProject.php?id='.$row['id'].'&stat=finished"><span class="badge bg-blue">'.$stat_finished['finished'].'</span></a></td>';
					}

					if($stat_ongoing['ongoing']==0){
						echo '<td><span class="badge bg-red">'.$stat_ongoing['ongoing'].'</span></td>';
					}else{
						echo '<td><a href="ongoingProject.php?id='.$row['id'].'&stat=ongoing"><span class="badge bg-blue">'.$stat_ongoing['ongoing'].'</span></a></td>';
					}
					echo '</tr>';

				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}

		}


		function fetchAccomplishedProjects(){
			global $dbh;
			$id = $_GET['id'];
			try{
				$query = $dbh->query("SELECT projectName as `pn`, projectID as `pid`,
									skillName as `sn`,
									status, clientName as `cn`
									FROM project p 
									LEFT JOIN skills s ON p.skillReq = s.skillID
									WHERE status='finished' AND draftsmanID = $id;
									");

				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){

					echo '<tr>';
					echo '<td><b>'.$row['pn'].'</b></td>';
					echo '<td><i>'.$row['cn'].'</i></td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td><a href="projectLog.php?pid='.$row['pid'].'&eid='.$id.'&type=acc"><button class="btn btn-info btn-sm" type="button"><span class="glyphicon glyphicon-stats"></span> View Logs</button></a></td>';
					echo '</tr>';
				  
				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchOngoingProjects2(){
			global $dbh;
			$id = $_GET['id'];
			try{
				$query = $dbh->query("SELECT projectName as `pn`, projectID as `pid`,
									skillName as `sn`,
									status, clientName as `cn`
									FROM project p 
									LEFT JOIN skills s ON p.skillReq = s.skillID
									WHERE status='ongoing' AND draftsmanID = $id;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){

					echo '<tr>';
					echo '<td><b>'.$row['pn'].'</b></td>';
					echo '<td><i>'.$row['cn'].'</i></td>';
					echo '<td>'.$row['sn'].'</td>';

					echo '<td><a href="projectLog.php?pid='.$row['pid'].'&eid='.$id.'&type=ongoing"><button class="btn btn-info btn-sm" type="button"><span class="glyphicon glyphicon-stats"></span> View Logs</button></a></td>';
					echo '</tr>';
				  
				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchTutorReport(){
			global $dbh;

			try{
				/*$query = $dbh->query("SELECT DISTINCT(CONCAT(firstname,' ', lastname)) as `name`, picture, tutorial.empID as `id` FROM 
									skills 
									left join tutorial on tutorial.classID = skills.skillID
									left join account on tutorial.empID = account.empID 
									left join employee on account.empID = employee.employeeID 
									where account.type = 'Draftsman/Tutor'
									or account.type = 'Tutorial';
									");


				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$query_finished = $dbh->query("SELECT count(*) as `finished` FROM tutorial where  `status` = 'finished' and empID = '" .$row['id'] ."';");
					$query_ongoing = $dbh->query("SELECT count(*) as `ongoing` FROM tutorial where  `status` = 'ongoing' and empID = '". $row['id'] ."';");
					$stat_finished = $query_finished->fetch();
					$stat_ongoing = $query_ongoing->fetch();
										

					echo '<tr>'; 
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image" /></td>';
					echo '<td><b>'.$row['name'].'</b></td>';
					echo '<td><a href="accomplishedClasses.php?id='.$row['id'].'">'.$stat_finished['finished'].'</a></td>';
					echo '<td><a href="ongoingClasses.php?id='.$row['id'].'">'.$stat_ongoing['ongoing'].'</a></td>';
					echo '</tr>';

				}*/

				$query = $dbh->query("SELECT DISTINCT CONCAT(firstName,' ',lastName) as `name`, picture, e.employeeID as `id`
					FROM employee e	JOIN account a ON e.employeeID = a.empID
					WHERE type = 'Tutorial' OR type = 'Draftsman/Tutor'");

				while($row = $query->fetch()){
					$id = $row['id'];
					
					$fin = $dbh->query("SELECT COUNT(*) as `fin` FROM tutorial t JOIN employee e ON t.empID = e.employeeID WHERE t.empID='$id' AND status='finished'");
					$countfin = $fin->fetch();

					$ongoing = $dbh->query("SELECT COUNT(*) as `ongoing` FROM tutorial t JOIN employee e ON t.empID = e.employeeID WHERE t.empID='$id' AND status='ongoing'");
					$countongoing = $ongoing->fetch();
					echo '<tr>';
					echo '<td style="width:50px;"><img src="'.$row['picture'].'" class="img-square aaa" alt="User Image" /></td>';
					echo '<td>'.$row['name'].'</td>';
					
					if($countfin['fin']==0){
						echo '<td><span class="badge bg-red">'.$countfin['fin'].'</span></td>';
					}else{
						echo '<td><a href="accomplishedClasses.php?eid='.$row['id'].'&type=finished"><span class="badge bg-blue">'.$countfin['fin'].'</span></a></td>';
					}

					if($countongoing['ongoing']==0){
						echo '<td><span class="badge bg-red">'.$countongoing['ongoing'].' </span></td>';
					}else{
						echo '<td><a href="ongoingClasses.php?eid='.$row['id'].'&type=ongoing"><span class="badge bg-blue">'.$countongoing['ongoing'].' </span></a></td>';
					}
					echo '</tr>';
				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}

		}

		function fetchAccomplishedClasses(){
			global $dbh;
			$id = $_GET['id'];
			try{
				$query = $dbh->query("SELECT skillName as `sk`, skillID as `pid`,
									CONCAT(firstname,' ', lastname) as `name`,
									status
									FROM tutorial t 
									LEFT JOIN skills s ON t.classID = s.skillID
									LEFT JOIN student st ON s.skillID = st.classID
									WHERE status='finished' AND empID = $id
									GROUP BY skillName;
									");

				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){

					echo '<tr>';
					echo '<td><b>'.$row['sk'].'</b></td>';
					echo '<td><i>'.$row['name'].'</i></td>';
					echo '</tr>';
				  
				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchOngoingClasses2(){
			global $dbh;
			$id = $_GET['id'];
			try{
				$query = $dbh->query("SELECT skillName as `sk`, skillID as `pid`,
									CONCAT(firstname,' ', lastname) as `name`,
									status
									FROM tutorial t 
									LEFT JOIN skills s ON t.classID = s.skillID
									LEFT JOIN student st ON s.skillID = st.classID
									WHERE status='ongoing' AND empID = $id
									GROUP BY skillName;
									");

				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){

					echo '<tr>';
					echo '<td><b>'.$row['sk'].'</b></td>';
					echo '<td><i>'.$row['name'].'</i></td>';
					echo '</tr>';
				  
				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchProjectReport(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT * FROM
									(SELECT projectName as `pn`, projectID as `pid`,
									clientName as `client`, skillName as `sn`,
									CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
									totalNumHours as `due`,
									location,
									status, duedate,startdate, p.contactNum as `contact`
									FROM project p 
									JOIN employee e ON p.draftsmanID = e.employeeID
									JOIN skills s ON p.skillReq = s.skillID
									) as `tablename`
									;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){

					$pid = $row['pid'];

					date_default_timezone_set("Asia/Manila");
					$ddate = date("Y-m-d");

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['pid']);
					$dmodal = str_replace(' ', '', 'd'.$row['pid']);

					$d = date("F d, Y",strtotime($row['duedate']));
					$hours = floor($row['due'] / 60);
    				$minutes = ($row['due'] % 60);

    				$sub = $row['due'] / 60;
    				
    				$query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
									");
    				$row2 = $query2->fetch();

    				$h = floor($row2['consumed'] / 60);
    				$m = ($row2['consumed'] % 60);
					
					echo '<tr>';
					echo '<td><a href=#'.$modal.'><b>'.$row['pn'].'</b></a></td>';
					echo '<td><i>'.$row['draftsman'].'</i></td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$d.'</td>';


					if($hours == '0' && $minutes == '0' && $row['status'] == 'onhold'){
						echo '<td><b>ON-HOLD</b></td>';
					}else{
						echo '<td><b>'.$hours.' hrs and '.$minutes.' minutes</b></td>';
					}

					if($h == '0' && $m == '0'){
						echo '<td><i>Not Yet Started</i></td>';						
					}else{
						echo '<td><i>'.$h.' hrs and '.$m.' minutes</i></td>';
					}

					if($status == 'finished'){
						echo '<td><span class="badge bg-yellow">'.$status.'</span></td>';
					}else if($status == 'ongoing'){
						echo '<td><span class="badge bg-blue">'.$status.'</span></td>';
					}else if($status == 'cancelled'){
						echo '<td><span class="badge bg-red">'.$status.'</span></td>';
					}else if($status == 'hold'){
						echo '<td><span class="badge bg-green">'.$status.'</span></td>';
					}

					echo '<td><a href="viewLogs.php?id='.$row['pid'].'&type=all"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><span class="glyphicon glyphicon-stats"></span> View Logs</button></a></td>';
					echo '</tr>';

					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;"><b>'.$row['pn'].'</b></h4>
                				</div>

                				<div class="modal-body">
                					
					               <div style="text-align:center;">
					               		<p><b>START DATE</b>: '.date("F d, Y",strtotime($row['startdate'])).'</p>
						               	<p><b>DUE DATE</b>: '.date("F d, Y",strtotime($row['duedate'])).'</p>
						               	<p><b>CLIENT NAME</b>: '.$row['client'].'</p>
						               	<p><b>CONTACT NUMBER</b>: '.$row['contact'].'</p>
						               	<p><b>LOCATION</b>: '.$row['location'].'</p>';
						               	if($hours == '0' && $minutes == '0' && $row['status'] == 'onhold'){
											echo '<p><b>TIME LEFT:</b> ON-HOLD</p>';
										}else{
											echo '<p><b>TIME LEFT:</b> '.$hours.' hrs and '.$minutes.' minutes</b></td>';
										}
										if($h == '0' && $m == '0'){
											echo '<p><b>TIME CONSUMED</b>: Not Yet Started</p>';						
										}else{
											echo '<p><b>TIME CONSUMED</b>: '.$h.' hrs and '.$m.' minutes</p>';
										}

					                echo '</div>
					                <div class="modal-footer">';
					                if($status=='finished' || $status=='cancelled'){
						                echo '
						                	<a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
							               
					                		<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}else{
				                		echo '<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}
				                	
				                echo '</div>
				               	</div>
				            </div>

				          </div>';
				    echo '<div id="'.$dmodal.'" class="modalDialog">
				    		<div class="modal-dialog">
				    			
				    			<div class="modal-header text-center"><h4>'.$row['pn'].'</h4></div>
				    			<div class="modal-body text-center">
				    				<h4>Are you sure?</h4>
				    			</div>

				    			<div class="modal-footer">
					    				<a href="includes/deleteProj.php?pid='.$row['pid'].'">
						    				<button class="btn btn-danger" style=" float:left;" type="button">
								                YES
								            </button>
						            	</a>

						            <a href="#close"><button class="btn btn-default" type="button">NO</button></a>
				    			</div>

				    		</div>
				    	</div>';      


				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchLogs(){
			global $dbh;
			$pid = $_GET['id'];

			try{
				$query = $dbh->query("SELECT p.proj_ID as `pid`,
									p.timeIn as `timein`, p.timeOUt as `timeout`, p.date as `date`,
									hrWork as `work`
									FROM projwork p 
									WHERE p.proj_ID = $pid;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$d = date("F d, Y",strtotime($row['date']));
					$h = floor($row['work'] / 60);
                    $m = ($row['work'] % 60);
                    $ti = date("h:i A",strtotime($row['timein']));
                    $to = date("h:i A",strtotime($row['timeout']));
					echo '<tr>';
					echo '<td>'.$ti.'</a></td>';
					echo '<td>'.$to.'</td>';
					echo '<td><b>'.$h.' hrs and '.$m.' minutes</b></td>';
					echo '<td>'.$d.'</td>';
					echo '</tr>';
				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}


		function fetchDailyLogs(){
			global $dbh;
			$did = $_GET['id'];

			try{
				$query = $dbh->query("SELECT p.proj_ID as `pid`, pr.projectName as `name`,
									p.timeIn as `timein`, p.timeOUt as `timeout`, p.date as `date`,
									hrWork as `work`
									FROM projwork p
									JOIN project pr
									WHERE p.proj_ID = pr.projectID
									AND p.eID='$did';
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$h = floor($row['work'] / 60);
                    $m = ($row['work'] % 60);
                    $ti = date("h:i A",strtotime($row['timein']));
                    $to = date("h:i A",strtotime($row['timeout']));
					echo '<tr>';
					echo '<td>'.$row['name'].'</a></td>';
					echo '<td>'.$ti.'</a></td>';
					echo '<td>'.$to.'</td>';
					echo '<td><b>'.$h.' hrs and '.$m.' minutes</b></td>';
					echo '</tr>';
				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchProjectReportOngoing(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT * FROM
									(SELECT projectName as `pn`, projectID as `pid`,
									clientName as `client`, skillName as `sn`,
									CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
									location,
									totalNumHours as `due`,
									status as `status`, duedate, startdate, p.contactNum as `contact`
									FROM project p 
									JOIN employee e ON p.draftsmanID = e.employeeID
									JOIN skills s ON p.skillReq = s.skillID
									WHERE status = 'ongoing') as `tablename`
									;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){

					$pid = $row['pid'];

					date_default_timezone_set("Asia/Manila");
					$ddate = date("Y-m-d");

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['pid']);
					$dmodal = str_replace(' ', '', 'd'.$row['pid']);

					$d = date("F d, Y",strtotime($row['duedate']));
					$hours = floor($row['due'] / 60);
    				$minutes = ($row['due'] % 60);
    				
    				$query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
									");
    				$row2 = $query2->fetch();

    				$h = floor($row2['consumed'] / 60);
    				$m = ($row2['consumed'] % 60);

					echo '<tr>';
					echo '<td><a href=#'.$modal.'><b>'.$row['pn'].'</b></a></td>';
					echo '<td><i>'.$row['draftsman'].'</i></td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$d.'</td>';

					if($hours == '0' && $minutes == '0' && $row['status'] == 'onhold'){
						echo '<td><b>ON-HOLD</b></td>';
					}else{
						echo '<td><b>'.$hours.' hrs and '.$minutes.' minutes</b></td>';
					}

					if($h == '0' && $m == '0'){
						echo '<td><i>Not Yet Started</i></td>';						
					}else{
						echo '<td><i>'.$h.' hrs and '.$m.' minutes</i></td>';
					}

					echo '<td>'.$row['client'].'</td>';
					echo '<td><a href="viewLogs.php?id='.$row['pid'].'&type=ongoing"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><span class="glyphicon glyphicon-stats"></span> View Logs</button></a></td>';
					
					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;"><b>'.$row['pn'].'</b></h4>
                				</div>

                				<div class="modal-body">
                					
					               <div style="text-align:center;">
					               		<p><b>START DATE</b>: '.date("F d, Y",strtotime($row['startdate'])).'</p>
						               	<p><b>DUE DATE</b>: '.date("F d, Y",strtotime($row['duedate'])).'</p>
						               	<p><b>CLIENT NAME</b>: '.$row['client'].'</p>
						               	<p><b>CONTACT NUMBER</b>: '.$row['contact'].'</p>
						               	<p><b>LOCATION</b>: '.$row['location'].'</p>';
						               	if($hours == '0' && $minutes == '0' && $row['status'] == 'onhold'){
											echo '<p><b>TIME LEFT:</b> ON-HOLD</p>';
										}else{
											echo '<p><b>TIME LEFT:</b> '.$hours.' hrs and '.$minutes.' minutes</b></td>';
										}
										if($h == '0' && $m == '0'){
											echo '<p><b>TIME CONSUMED</b>: Not Yet Started</p>';						
										}else{
											echo '<p><b>TIME CONSUMED</b>: '.$h.' hrs and '.$m.' minutes</p>';
										}

					                echo '</div>
					                <div class="modal-footer">';
					                if($status=='finished' || $status=='cancelled'){
						                echo '
						                	<a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
							               
					                		<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}else{
				                		echo '<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}
				                	
				                echo '</div>
				               	</div>
				            </div>

				          </div>';
				    echo '<div id="'.$dmodal.'" class="modalDialog">
				    		<div class="modal-dialog">
				    			
				    			<div class="modal-header text-center"><h4>'.$row['pn'].'</h4></div>
				    			<div class="modal-body text-center">
				    				<h4>Are you sure?</h4>
				    			</div>

				    			<div class="modal-footer">
					    				<a href="includes/deleteProj.php?pid='.$row['pid'].'">
						    				<button class="btn btn-danger" style=" float:left;" type="button">
								                YES
								            </button>
						            	</a>

						            <a href="#close"><button class="btn btn-default" type="button">NO</button></a>
				    			</div>

				    		</div>
				    	</div>';
				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchProjectReportFinished(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT * FROM
									(SELECT projectName as `pn`, projectID as `pid`,
									clientName as `client`, skillName as `sn`,
									CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
									location, finishNo as `fn`,
									status, duedate, startdate,
									p.remarks as `remarks`,
									totalNumHours as `due`, p.contactNum as `contact`
									FROM project p 
									JOIN employee e ON p.draftsmanID = e.employeeID
									JOIN skills s ON p.skillReq = s.skillID
									WHERE status = 'finished') as `tablename`
									;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$pid = $row['pid'];

					date_default_timezone_set("Asia/Manila");
					$ddate = date("Y-m-d");

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['pid']);
					$dmodal = str_replace(' ', '', 'd'.$row['pid']);

					$d = date("F d, Y",strtotime($row['duedate']));
					$hours = floor($row['due'] / 60);
    				$minutes = ($row['due'] % 60);
    				
    				$query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
									");
    				$row2 = $query2->fetch();

    				$h = floor($row2['consumed'] / 60);
    				$m = ($row2['consumed'] % 60);

					echo '<tr>';
					echo '<td><a href=#'.$modal.'><b>'.$row['pn'].'</b></a></td>';
					echo '<td><i>'.$row['draftsman'].'</i></td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$d.'</td>';
					if($h == '0' && $m == '0'){
						echo '<td><i>Not Yet Started</i></td>';						
					}else{
						echo '<td><i>'.$h.' hrs and '.$m.' minutes</i></td>';
					}
					echo '<td>'.$row['client'].'</td>';
					echo '<td><a href="viewLogs.php?id='.$row['pid'].'&type=finished"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><span class="glyphicon glyphicon-stats"></span> View Logs</button></a></td>';
					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;"><b>'.$row['pn'].'</b></h4>
                				</div>

                				<div class="modal-body">
                					
					               <div style="text-align:center;">';

					               if($row['fn'] == NULL){
					               	echo '<p><b>ENTRY NUMBER</b>: none</p>';
					               }else{
					               	echo '<p><b>ENTRY NUMBER</b>: '.$row['fn'].'</p>';
					               }
										
					echo '					<p><b>START DATE</b>: '.date("F d, Y",strtotime($row['startdate'])).'</p>
						               	<p><b>DUE DATE</b>: '.date("F d, Y",strtotime($row['duedate'])).'</p>
						               	<p><b>CLIENT NAME</b>: '.$row['client'].'</p>
						               	<p><b>CONTACT NUMBER</b>: '.$row['contact'].'</p>
						               	<p><b>LOCATION</b>: '.$row['location'].'</p>';
						               	
										if($h == '0' && $m == '0'){
											echo '<p><b>TIME CONSUMED</b>: Not Yet Started</p>';						
										}else{
											echo '<p><b>TIME CONSUMED</b>: '.$h.' hrs and '.$m.' minutes</p>';
										}
										if($row['remarks'] == NULL){
											echo '<p><b>REMARKS</b>: none</p>';
										}else{
											echo '<p><b>REMARKS</b>: '.$row['remarks'].'</p>';
										}

					                echo '</div>
					                <div class="modal-footer">';
					                if($status=='finished' || $status=='cancelled'){
						                echo '
						                	<a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
							               
					                		<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}else{
				                		echo '<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}
				                	
				                echo '</div>
				               	</div>
				            </div>

				          </div>';
				    echo '<div id="'.$dmodal.'" class="modalDialog">
				    		<div class="modal-dialog">
				    			
				    			<div class="modal-header text-center"><h4>'.$row['pn'].'</h4></div>
				    			<div class="modal-body text-center">
				    				<h4>Are you sure?</h4>
				    			</div>

				    			<div class="modal-footer">
					    				<a href="includes/deleteProj.php?pid='.$row['pid'].'">
						    				<button class="btn btn-danger" style=" float:left;" type="button">
								                YES
								            </button>
						            	</a>

						            <a href="#close"><button class="btn btn-default" type="button">NO</button></a>
				    			</div>

				    		</div>
				    	</div>';
				
				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchProjectReportHold(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT * FROM
									(SELECT projectName as `pn`, projectID as `pid`,
									clientName as `client`, skillName as `sn`,
									CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
									location, totalNumHours as `due`, p.holdNo as `hn`,
									status, duedate, startdate, p.contactNum as `contact`,
									p.remarks as `remarks`
									FROM project p 
									JOIN employee e ON p.draftsmanID = e.employeeID
									JOIN skills s ON p.skillReq = s.skillID
									WHERE status = 'hold') as `tablename`
									;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					
					$pid = $row['pid'];

					date_default_timezone_set("Asia/Manila");
					$ddate = date("Y-m-d");

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['pid']);
					$dmodal = str_replace(' ', '', 'd'.$row['pid']);


					$d = date("F d, Y",strtotime($row['duedate']));
					$hours = floor($row['due'] / 60);
    				$minutes = ($row['due'] % 60);
    				
    				$query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
									");
    				$row2 = $query2->fetch();

    				$h = floor($row2['consumed'] / 60);
    				$m = ($row2['consumed'] % 60);

					echo '<tr>';
					echo '<td><a href=#'.$modal.'><b>'.$row['pn'].'</b></a></td>';
					echo '<td><i>'.$row['draftsman'].'</i></td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$d.'</td>';

					if($hours == '0' && $minutes == '0' && $row['status'] == 'onhold'){
						echo '<td><b>ON-HOLD</b></td>';
					}else{
						echo '<td><b>'.$hours.' hrs and '.$minutes.' minutes</b></td>';
					}

					if($h == '0' && $m == '0'){
						echo '<td><i>Not Yet Started</i></td>';						
					}else{
						echo '<td><i>'.$h.' hrs and '.$m.' minutes</i></td>';
					}

					echo '<td>'.$row['client'].'</td>';
					echo '<td><a href="viewLogs.php?id='.$row['pid'].'&type=hold"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><span class="glyphicon glyphicon-stats"></span> View Logs</button></a></td>';
					
					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;"><b>'.$row['pn'].'</b></h4>
                				</div>

                				<div class="modal-body">
                					
					               <div style="text-align:center;">';
									if($row['hn'] == NULL){
					               	echo '<p><b>ENTRY NUMBER</b>: none</p>';
					               }else{
					               	echo '<p><b>ENTRY NUMBER</b>: '.$row['hn'].'</p>';
					               }
					echo '					<p><b>START DATE</b>: '.date("F d, Y",strtotime($row['startdate'])).'</p>
						               	<p><b>DUE DATE</b>: '.date("F d, Y",strtotime($row['duedate'])).'</p>
						               	<p><b>CLIENT NAME</b>: '.$row['client'].'</p>
						               	<p><b>CONTACT NUMBER</b>: '.$row['contact'].'</p>
						               	<p><b>LOCATION</b>: '.$row['location'].'</p>';
						               	if($hours == '0' && $minutes == '0' && $row['status'] == 'onhold'){
											echo '<p><b>TIME LEFT:</b> ON-HOLD</p>';
										}else{
											echo '<p><b>TIME LEFT:</b> '.$hours.' hrs and '.$minutes.' minutes</b></td>';
										}
										if($h == '0' && $m == '0'){
											echo '<p><b>TIME CONSUMED</b>: Not Yet Started</p>';						
										}else{
											echo '<p><b>TIME CONSUMED</b>: '.$h.' hrs and '.$m.' minutes</p>';
										}
										if($row['remarks'] == NULL){
											echo '<p><b>REMARKS</b>: none</p>';
										}else{
											echo '<p><b>REMARKS</b>: '.$row['remarks'].'</p>';
										}
										

					                echo '</div>
					                <div class="modal-footer">';
					                if($status=='finished' || $status=='cancelled'){
						                echo '
						                	<a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
							               
					                		<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}else{
				                		echo '<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}
				                	
				                echo '</div>
				               	</div>
				            </div>

				          </div>';
				    echo '<div id="'.$dmodal.'" class="modalDialog">
				    		<div class="modal-dialog">
				    			
				    			<div class="modal-header text-center"><h4>'.$row['pn'].'</h4></div>
				    			<div class="modal-body text-center">
				    				<h4>Are you sure?</h4>
				    			</div>

				    			<div class="modal-footer">
					    				<a href="includes/deleteProj.php?pid='.$row['pid'].'">
						    				<button class="btn btn-danger" style=" float:left;" type="button">
								                YES
								            </button>
						            	</a>

						            <a href="#close"><button class="btn btn-default" type="button">NO</button></a>
				    			</div>

				    		</div>
				    	</div>';

				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}

		function fetchProjectReportCancelled(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT * FROM
									(SELECT projectName as `pn`, projectID as `pid`,
									clientName as `client`, skillName as `sn`,
									p.cancelNo as `cn`,
									CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
									location, p.remarks as `remarks`,
									status, duedate, startdate,
									totalNumHours as `due`, p.contactNum as `contact`
									FROM project p 
									JOIN employee e ON p.draftsmanID = e.employeeID
									JOIN skills s ON p.skillReq = s.skillID
									WHERE status = 'cancelled') as `tablename`
									;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					
					$pid = $row['pid'];

					date_default_timezone_set("Asia/Manila");
					$ddate = date("Y-m-d");

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['pid']);
					$dmodal = str_replace(' ', '', 'd'.$row['pid']);


					$d = date("F d, Y",strtotime($row['duedate']));
					$hours = floor($row['due'] / 60);
    				$minutes = ($row['due'] % 60);
    				
    				$query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
									");
    				$row2 = $query2->fetch();

    				$h = floor($row2['consumed'] / 60);
    				$m = ($row2['consumed'] % 60);

					echo '<tr>';
					echo '<td><a href=#'.$modal.'><b>'.$row['pn'].'</b></a></td>';
					echo '<td><i>'.$row['draftsman'].'</i></td>';
					echo '<td>'.$row['sn'].'</td>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$d.'</td>';

					if($h == '0' && $m == '0'){
						echo '<td><i>Not Yet Started</i></td>';						
					}else{
						echo '<td><i>'.$h.' hrs and '.$m.' minutes</i></td>';
					}

					echo '<td>'.$row['client'].'</td>';
					echo '<td><a href="viewLogs.php?id='.$row['pid'].'&type=cancelled"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><span class="glyphicon glyphicon-stats"></span> View Logs</button></a></td>';
					
					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;"><b>'.$row['pn'].'</b></h4>
                				</div>

                				<div class="modal-body">
                					
					               <div style="text-align:center;">';
						               	if($row['cn'] == NULL){
					               	echo '<p><b>ENTRY NUMBER</b>: none</p>';
					               }else{
					               	echo '<p><b>ENTRY NUMBER</b>: '.$row['cn'].'</p>';
					               }
					    echo '           <p><b>START DATE</b>: '.date("F d, Y",strtotime($row['startdate'])).'</p>
						               	<p><b>DUE DATE</b>: '.date("F d, Y",strtotime($row['duedate'])).'</p>
						               	<p><b>CLIENT NAME</b>: '.$row['client'].'</p>
						               	<p><b>CONTACT NUMBER</b>: '.$row['contact'].'</p>
						               	<p><b>LOCATION</b>: '.$row['location'].'</p>';
						               	
										if($h == '0' && $m == '0'){
											echo '<p><b>TIME CONSUMED</b>: Not Yet Started</p>';						
										}else{
											echo '<p><b>TIME CONSUMED</b>: '.$h.' hrs and '.$m.' minutes</p>';
										}
										if($row['remarks'] == NULL){
											echo '<p><b>REMARKS</b>: none</p>';
										}else{
											echo '<p><b>REMARKS</b>: '.$row['remarks'].'</p>';
										}


					                echo '</div>
					                <div class="modal-footer">';
					                if($status=='finished' || $status=='cancelled'){
						                echo '
						                	<a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
							               
					                		<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}else{
				                		echo '<a href="#close"><button class="btn btn-default" type="button">Close</button></a>';
				                	}
				                	
				                echo '</div>
				               	</div>
				            </div>

				          </div>';
				    echo '<div id="'.$dmodal.'" class="modalDialog">
				    		<div class="modal-dialog">
				    			
				    			<div class="modal-header text-center"><h4>'.$row['pn'].'</h4></div>
				    			<div class="modal-body text-center">
				    				<h4>Are you sure?</h4>
				    			</div>

				    			<div class="modal-footer">
					    				<a href="includes/deleteProj.php?pid='.$row['pid'].'">
						    				<button class="btn btn-danger" style=" float:left;" type="button">
								                YES
								            </button>
						            	</a>

						            <a href="#close"><button class="btn btn-default" type="button">NO</button></a>
				    			</div>

				    		</div>
				    	</div>';

				
				}

			}catch(PDOException $ex){
				echo $ex->getMessage();
			}	
		}


		function fetchClassReport(){
			global $dbh;

			try{
				$getOngoing = $dbh->query("SELECT CONCAT(e.firstName,' ',e.lastName) as `tutor`, st.studentID as `sid`, CONCAT(st.firstName,' ',st.lastName) as `name`, 
										sk.skillName as `class`, st.instid as `inst`, t.status as `status`, st.session as `session`, st.email as `email`,
										st.contact as `contact`, t.tutorialID as `tid`, e.employeeID as `eid`,GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`, 
                                                        GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`
										FROM student st
                                                        JOIN schedule ss ON st.studentID = ss.studID 
                                                        JOIN skills sk ON st.classID = sk.skillID
                                                        JOIN tutorial t ON t.studID = st.studentID
                                                        JOIN employee e ON t.empID=e.employeeID
                                                        WHERE ss.classsched = '1'
									GROUP BY t.studID ");
				$getOngoing->execute();
				$report = $getOngoing->fetchAll();
				
				foreach($report as $row) {
					$sid = $row['sid'];

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['sid']);
					$dmodal = str_replace(' ', '', 'd'.$row['sid']);

					echo "<tr>";
					echo '<td><a href=#'.$modal.'><b>'.$row['class'].'</b></a></td>';
					echo "<td><i>".$row['name']."</i></td>";
					echo "<td>".$row['tutor']."</td>";
					echo '<td>'.$row['schedule'].' <br><br> '.$row['time'].'</td>';
					echo "<td style='text-align:center;'><span class='badge bg-yellow'>".$row['session']." sessions</span></td>";

					if($row['status'] == 'ongoing'){
						echo "<td style='text-align:center;'><span class='badge bg-blue'>".$row['status']."</span></td>";
					}else if($row['status'] == 'dropped'){
						echo "<td style='text-align:center;'><span class='badge bg-red'>".$row['status']."</span></td>";
					}else if($row['status'] == 'finished'){
						echo "<td style='text-align:center;'><span class='badge bg-yellow'>".$row['status']."</span></td>";
					}
					echo '<td><a href="viewCCard2.php?id='.$row['sid'].'&n='.$row['name'].'&c='.$row['class'].'&i='.$row['inst'].'&tid='.$row['tid'].'&type=all"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><i class="fa fa-book"></i>&nbsp;View Classcard</button></a></td>';
					echo "</tr>";

					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Tutor: </b>'.$row['tutor'].'</p>
                					<p><b>Class: </b>'.$row['name'].'</p>
                					<p><b>Email: </b>'.$row['email'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
				                
				                </div>

				                <div class="modal-footer" style="margin-top:30px;">';
				            	if($status == 'finished' || $status == 'dropped'){
				            		echo '<a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
				                	<a href="#close"><button class="btn btn-default">CLOSE</button></a>';
				            	}else{
				            		echo '<a href="#close"><button class="btn btn-default">CLOSE</button></a>';
				            	}
				                
				    echo '            </div>
				            </div>


				        </div>';

				    	echo '<div id="'.$dmodal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
					                <div style="text-align:left;">
					                	<h4><b>Delete the Class?</b></h4>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	<a href=#'.$modal.'><button class="btn btn-default">BACK</button></a>
				                	<a href="includes/deleteClass2.php?tid='.$row['tid'].'&eid='.$row['eid'].'"><button class="btn btn-info">YES</button></a>
				                </div>
				            </div>
				        </div>';
				}
			}catch(PDOExeption $ex){
				echo $ex->getMessage();
			}

		}

		function fetchClassReportOngoing(){
			global $dbh;

			try{
				$getOngoing = $dbh->query("SELECT CONCAT(e.firstName,' ',e.lastName) as `tutor`, st.studentID as `sid`, CONCAT(st.firstName,' ',st.lastName) as `name`, 
										sk.skillName as `class`, st.instid as `inst`, t.status as `status`, st.session as `session`, st.email as `email`,
										st.contact as `contact`, t.tutorialID as `tid`, e.employeeID as `eid`,GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`, 
                                                        GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`
										FROM student st
                                                        JOIN schedule ss ON st.studentID = ss.studID 
                                                        JOIN skills sk ON st.classID = sk.skillID
                                                        JOIN tutorial t ON t.studID = st.studentID
                                                        JOIN employee e ON t.empID=e.employeeID
                                                        WHERE ss.classsched = '1' AND t.status = 'ongoing' AND st.session > 0
									GROUP BY t.studID ");
				$getOngoing->execute();
				$report = $getOngoing->fetchAll();
				
				foreach($report as $row) {
					$sid = $row['sid'];

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['sid']);
					$dmodal = str_replace(' ', '', 'd'.$row['sid']);

					echo "<tr>";
					echo '<td><a href=#'.$modal.'><b>'.$row['class'].'</b></a></td>';
					echo "<td><i>".$row['name']."</i></td>";
					echo "<td>".$row['tutor']."</td>";
					echo '<td>'.$row['schedule'].' <br><br> '.$row['time'].'</td>';
					echo "<td style='text-align:center;'><span class='badge bg-yellow'>".$row['session']." sessions</span></td>";

					if($row['status'] == 'ongoing'){
						echo "<td style='text-align:center;'><span class='badge bg-blue'>".$row['status']."</span></td>";
					}else if($row['status'] == 'dropped'){
						echo "<td style='text-align:center;'><span class='badge bg-red'>".$row['status']."</span></td>";
					}else if($row['status'] == 'finished'){
						echo "<td style='text-align:center;'><span class='badge bg-yellow'>".$row['status']."</span></td>";
					}
					echo '<td><a href="viewCCard2.php?id='.$row['sid'].'&n='.$row['name'].'&c='.$row['class'].'&i='.$row['inst'].'&tid='.$row['tid'].'&type=ongoing"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><i class="fa fa-book"></i>&nbsp;View Classcard</button></a></td>';
					echo "</tr>";

					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Tutor: </b>'.$row['tutor'].'</p>
                					<p><b>Class: </b>'.$row['name'].'</p>
                					<p><b>Email: </b>'.$row['email'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
				                
				                </div>

				                <div class="modal-footer" style="margin-top:30px;">
				                <a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
				                	<a href="#close"><button class="btn btn-default">CLOSE</button></a>
				                </div>
				            </div>


				        </div>';

				    	echo '<div id="'.$dmodal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
					                <div style="text-align:left;">
					                	<h4><b>Delete the Class?</b></h4>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	<a href=#'.$modal.'><button class="btn btn-default">BACK</button></a>
				                	<a href="includes/deleteClass2.php?tid='.$row['tid'].'&eid='.$row['eid'].'"><button class="btn btn-info">YES</button></a>
				                </div>
				            </div>
				        </div>';
				}
			}catch(PDOExeption $ex){
				echo $ex->getMessage();
			}


		}

		function fetchClassReportFinished(){
			global $dbh;

			try{
				$getOngoing = $dbh->query("SELECT CONCAT(e.firstName,' ',e.lastName) as `tutor`, st.studentID as `sid`, CONCAT(st.firstName,' ',st.lastName) as `name`, 
										sk.skillName as `class`, st.instid as `inst`, t.status as `status`, st.session as `session`, st.email as `email`,
										st.contact as `contact`, t.tutorialID as `tid`, e.employeeID as `eid`
										FROM tutorial t 
										JOIN employee e ON t.empID=e.employeeID 
										JOIN student st ON t.studID=st.studentID 
										JOIN skills sk ON t.classID = sk.skillID
										WHERE status = 'finished'");
				$getOngoing->execute();
				$report = $getOngoing->fetchAll();
				
				foreach($report as $row) {
					$sid = $row['sid'];

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['sid']);
					$dmodal = str_replace(' ', '', 'd'.$row['sid']);

					echo "<tr>";
					echo '<td><a href=#'.$modal.'><b>'.$row['class'].'</b></a></td>';
					echo "<td><i>".$row['name']."</i></td>";
					echo "<td>".$row['tutor']."</td>";

					if($row['status'] == 'ongoing'){
						echo "<td style='text-align:center;'><span class='badge bg-blue'>".$row['status']."</span></td>";
					}else if($row['status'] == 'dropped'){
						echo "<td style='text-align:center;'><span class='badge bg-red'>".$row['status']."</span></td>";
					}else if($row['status'] == 'finished'){
						echo "<td style='text-align:center;'><span class='badge bg-yellow'>".$row['status']."</span></td>";
					}
					echo '<td><a href="viewCCard2.php?id='.$row['sid'].'&n='.$row['name'].'&c='.$row['class'].'&i='.$row['inst'].'&tid='.$row['tid'].'&type=finished"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><i class="fa fa-book"></i>&nbsp;View Classcard</button></a></td>';
					echo "</tr>";

					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Tutor: </b>'.$row['tutor'].'</p>
                					<p><b>Class: </b>'.$row['name'].'</p>
                					<p><b>Email: </b>'.$row['email'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
				                
				                </div>

				                <div class="modal-footer" style="margin-top:30px;">
				                <a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
				                	<a href="#close"><button class="btn btn-default">CLOSE</button></a>
				                </div>
				            </div>


				        </div>';

				    	echo '<div id="'.$dmodal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
					                <div style="text-align:left;">
					                	<h4><b>Delete the Class?</b></h4>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	<a href=#'.$modal.'><button class="btn btn-default">BACK</button></a>
				                	<a href="includes/deleteClass2.php?tid='.$row['tid'].'&eid='.$row['eid'].'"><button class="btn btn-info">YES</button></a>
				                </div>
				            </div>
				        </div>';
				}
			}catch(PDOExeption $ex){
				echo $ex->getMessage();
			}


		}

		function fetchClassReportDropped(){
			global $dbh;

			try{
				$getOngoing = $dbh->query("SELECT CONCAT(e.firstName,' ',e.lastName) as `tutor`, st.studentID as `sid`, CONCAT(st.firstName,' ',st.lastName) as `name`, 
										sk.skillName as `class`, st.instid as `inst`, t.status as `status`, st.session as `session`, st.email as `email`,
										st.contact as `contact`, t.tutorialID as `tid`, e.employeeID as `eid`
										FROM tutorial t 
										JOIN employee e ON t.empID=e.employeeID 
										JOIN student st ON t.studID=st.studentID 
										JOIN skills sk ON t.classID = sk.skillID
										WHERE status = 'dropped'");
				$getOngoing->execute();
				$report = $getOngoing->fetchAll();
				
				foreach($report as $row) {
					$sid = $row['sid'];

					$status = $row['status'];
					$modal = str_replace(' ', '', $row['sid']);
					$dmodal = str_replace(' ', '', 'd'.$row['sid']);

					echo "<tr>";
					echo '<td><a href=#'.$modal.'><b>'.$row['class'].'</b></a></td>';
					echo "<td><i>".$row['name']."</i></td>";
					echo "<td>".$row['tutor']."</td>";

					if($row['status'] == 'ongoing'){
						echo "<td style='text-align:center;'><span class='badge bg-blue'>".$row['status']."</span></td>";
					}else if($row['status'] == 'dropped'){
						echo "<td style='text-align:center;'><span class='badge bg-red'>".$row['status']."</span></td>";
					}else if($row['status'] == 'finished'){
						echo "<td style='text-align:center;'><span class='badge bg-yellow'>".$row['status']."</span></td>";
					}
					echo '<td><a href="viewCCard2.php?id='.$row['sid'].'&n='.$row['name'].'&c='.$row['class'].'&i='.$row['inst'].'&tid='.$row['tid'].'&type=dropped"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><i class="fa fa-book"></i>&nbsp;View Classcard</button></a></td>';
					echo "</tr>";

					echo '<div id="'.$modal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
                					<p><b>Tutor: </b>'.$row['tutor'].'</p>
                					<p><b>Class: </b>'.$row['name'].'</p>
                					<p><b>Email: </b>'.$row['email'].'</p>
                					<p><b>Contact Number: </b>'.$row['contact'].'</p>
				                
				                </div>

				                <div class="modal-footer" style="margin-top:30px;">
				                <a href=#'.$dmodal.'>
							               		<button class="btn btn-danger" style=" float:left;" type="button">
							                        Delete
							                 	</button>
							                </a>
				                	<a href="#close"><button class="btn btn-default">CLOSE</button></a>
				                </div>
				            </div>


				        </div>';

				    	echo '<div id="'.$dmodal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body">
					                <div style="text-align:left;">
					                	<h4><b>Delete the Class?</b></h4>

	                				</div>
				                
				                </div>

				                <div class="modal-footer">
				                	<a href=#'.$modal.'><button class="btn btn-default">BACK</button></a>
				                	<a href="includes/deleteClass2.php?tid='.$row['tid'].'&eid='.$row['eid'].'"><button class="btn btn-info">YES</button></a>
				                </div>
				            </div>
				        </div>';
				}
			}catch(PDOExeption $ex){
				echo $ex->getMessage();
			}

		}


		function fetchInquiries() {
			global $dbh;

			try {
				$query = $dbh -> query("SELECT * FROM
					(SELECT inqid, message, email, CONCAT(firstName,' ',lastName) as `name`, dateSent as `date` FROM inquiries ORDER BY `date`) as `table`");

				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()) {
					//$modalTitle = str_replace(' ', '', $row['inqid']);
					//$modalDelete = str_replace(' ', '', $row['inqid']);
					$message = htmlspecialchars(substr($row['message'], 0, 20));
					$modalTitle = str_replace(' ', '', $row['inqid']);
					$deleteModal = str_replace(' ', '', 'delete'.$row['inqid']);
					$email = htmlspecialchars($row['email']);
					$name = htmlspecialchars($row['name']);

					$d = date("F d, Y",strtotime($row['date']));

					echo '<tr>';
					echo '<td><input name="message[]" type="checkbox" id="checkbox[]" value="'.$row['inqid'].'" >&nbsp;&nbsp;&nbsp;<a href="#'.$modalTitle.'">'.$message.' ..</a></td>';
					echo '<td>'.$row['email'].'</td>';
					echo '<td>'.$d.'</td>';	
					echo '</tr>';

					echo '<div id="'.$modalTitle.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;">Message Body</h4>
                				</div>

                				<div class="modal-body">
                					<p><b>Sender:<br></b>'.$name.'</p>
				                	<p><b>From:<br></b>'.$email.'</p>
				             		<p><b>Message:<br></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .$message. '</p>
					               <div style="text-align:center;">

						               

					                </div>

					                <div class="modal-footer" style="margin-top:100px;">
					                	<a href="inquiries.php?id='.$row['inqid'].'">
						               		<button class="btn btn-danger" style=" float:left;" type="button">
						                        Delete
						                 </button>
						               </a>
				                		<a href="#close"><button class="btn btn-default" type="button">Close</button></a>
				                	</div>
				               	</div>
				            </div>

				          </div>';


				}

			} catch (PDOException $ex) {
				echo $ex -> getMessage();
			}
		}//fetchInquiries


/************END OF FETCH**************/
		function editProfile2($pangalan,$pangals,$sid){
			global $dbh;

			try{
				$query = $dbh->prepare("UPDATE student SET firstName=:pangalan, lastName=:pangals WHERE studentID=:sid;");
				$query -> bindParam(":pangalan", $pangalan);
				$query -> bindParam(":pangals", $pangals);
				$query -> bindParam(":sid", $sid);
				$query -> execute();
			} catch (PDOException $e) {
				echo $e->getMessage();
	        	die();	
			  }
		}

		function editAdminProfile($first, $last, $contact, $address, $email, $bday, $pic, $empid, $user, $password) {
			global $dbh;

			try {
				$query = $dbh->prepare("UPDATE employee SET firstName=:first, lastName=:last, contactNum=:contact, address=:address, email=:email, bday=:bday, picture=:pic WHERE employeeID=:empid;");
				$query -> bindParam(":first", $first);
				$query -> bindParam(":last", $last);
				$query -> bindParam(":contact", $contact);
				$query -> bindParam(":address", $address);
				$query -> bindParam(":email", $email);
				$query -> bindParam(":bday", $bday);
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

				$query = $dbh->prepare("UPDATE account SET username=:user, password=:password WHERE empID=:empid;");
				$query -> bindParam(":user", $user);
				$query -> bindParam(":password", $password);
				$query -> bindParam(":empid", $empid);
				$query -> execute();

				echo "<script>window.location='editAdminProfile.php?id=".$empid."&s=success'</script>";
				
			} catch (PDOException $e) {
				echo $e->getMessage();
	        	die();	
			  }
		}

		function editProfile($first, $last, $contact, $address, $email, $bday, $pic, $empid, $user, $password, $type){
			global $dbh;

			try {
				$query = $dbh->prepare("UPDATE employee SET firstName=:first, lastName=:last, contactNum=:contact, address=:address, email=:email, bday=:bday, picture=:pic WHERE employeeID=:empid;");
				$query -> bindParam(":first", $first);
				$query -> bindParam(":last", $last);
				$query -> bindParam(":contact", $contact);
				$query -> bindParam(":address", $address);
				$query -> bindParam(":email", $email);
				$query -> bindParam(":bday", $bday);
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

				$query = $dbh->prepare("UPDATE account SET username=:user, password=:password, type=:type WHERE empID=:empid;");
				$query -> bindParam(":user", $user);
				$query -> bindParam(":password", $password);
				$query -> bindParam(":type", $type);
				$query -> bindParam(":empid", $empid);
				$query -> execute();

				echo "<script>window.location='editEmpProfile.php?id=".$empid."&s=success'</script>";

			} catch (PDOException $e) {
				echo $e->getMessage();
	        	die();	
			  }
		}//editProfile

		function deleteSkill($empid) {
			global $dbh;
			$delete = $empid;
			try {
				$query = $dbh -> prepare('DELETE FROM skillemp WHERE empID=?');
				$query -> bindParam(1,$delete);
				$query -> execute();

			} catch(PDOException $ex) {
				echo $ex -> getMessage();
			}
		}

		function insertTutorial($studID,$tutor,$class){
			global $dbh; 

			try {
				$status = 'ongoing';
				$query = $dbh -> prepare("INSERT INTO tutorial(empID,studID,classID,status) VALUES (:empid,:studid,:classid,:status)");
				$query ->bindParam(":empid",$tutor);
				$query ->bindParam(":studid",$studID);
				$query ->bindParam(":classid",$class);
				$query ->bindParam(":status",$status);
				$query -> execute();
				
			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}

		}


		function substitute($tid,$eid,$subdate,$attendance,$id){
			global $dbh; 

			try {

				$query = $dbh -> prepare("INSERT INTO class(tutorialID,instID,`date`,attendance) VALUES (:tid,:eid,:subdate,:attendance)");
				$query ->bindParam(":tid",$tid);
				$query ->bindParam(":eid",$eid);
				$query ->bindParam(":subdate",$subdate);
				$query ->bindParam(":attendance",$attendance);
				$query -> execute();

				$this->substituteTimeline($tid,$id,$eid);

				echo '<script>windows: location="listOfClasses.php?s=s"</script>';
				
			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}

		}

		function timeline(){
				date_default_timezone_set('Asia/Manila');   

                global $dbh;
                $query = $dbh -> prepare('SELECT a.empID as `id`,
                    b.firstName as `fn`, 
                    b.lastName as `ln`,
                    a.msg as `msg`, 
                    a.time as `time`,
                    a.date as `date`,
                    a.icon as `icon`
                    FROM timeline a
                    INNER JOIN employee b
                    ON a.empID = b.employeeID
                    ORDER BY  a.tlID DESC 
                    LIMIT 30');
                   try{
                $query->execute();
                $temp = 1;
                
                while($row = $query -> fetch() ) {
                		  	
                if($temp == 1){
                	$d = date("F d, Y",strtotime($row["date"]));
                  $date2 = $row["date"];
                  $date = $date2;
                  $date3 = $date;
                  $temp = 2;
                  echo"<li class='time-label'><span class='bg-red'>".$d."</span></li>";
  			  		echo "<li> <i class='".$row["icon"]."'></i>";
	    			echo "<div class='timeline-item'>";
	   				echo "<span class='time'><i class='fa fa-clock-o'></i>  ".$row["time"]."</span>";

	   				if($row['ln'] == 'Administrator' && $row['fn'] == 'Administrator'){
	   					echo "<h3 class='timeline-header'> <a href='#'>".$row["ln"]."</a>:&nbsp;&nbsp;&nbsp;&nbsp;".$row["msg"]."</h3>";
	   				}else{
	   					echo "<h3 class='timeline-header'> <a href='#'>".$row["fn"]." ".$row["ln"]."</a>:&nbsp;&nbsp;&nbsp;&nbsp;".$row["msg"]."</h3>";
	   				}
	  		 		
	  			  	echo "</div></li>";
                }elseif($date3 == $date2){
	    			echo "<li> <i class='".$row["icon"]."'></i>";
	    			echo "<div class='timeline-item'>";
	   				echo "<span class='time'><i class='fa fa-clock-o'></i> ".$row["time"]."</span>";
	  		 		if($row['ln'] == 'Administrator' && $row['fn'] == 'Administrator'){
	   					echo "<h3 class='timeline-header'> <a href='#'>".$row["ln"]."</a>:&nbsp;&nbsp;&nbsp;&nbsp;".$row["msg"]."</h3>";
	   				}else{
	   					echo "<h3 class='timeline-header'> <a href='#'>".$row["fn"]." ".$row["ln"]."</a>:&nbsp;&nbsp;&nbsp;&nbsp;".$row["msg"]."</h3>";
	   				}
	  			  	echo "</div></li>";
	  			  	$date3 = $date;
	  			  	$date2 = $row["date"];
	  			  	$date = $date2;
	  			  	
  			  	}elseif($date3 > $date2){
  			  		echo"<li class='time-label'><span class='bg-red'>".$d."</span></li>";
  			  		echo "<li> <i class='".$row["icon"]."'></i>";
	    			echo "<div class='timeline-item'>";
	   				echo "<span class='time'><i class='fa fa-clock-o'></i>  ".$row["time"]."</span>";
	  		 		if($row['ln'] == 'Administrator' && $row['fn'] == 'Administrator'){
	   					echo "<h3 class='timeline-header'> <a href='#'>".$row["ln"]."</a>:&nbsp;&nbsp;&nbsp;&nbsp;".$row["msg"]."</h3>";
	   				}else{
	   					echo "<h3 class='timeline-header'> <a href='#'>".$row["fn"]." ".$row["ln"]."</a>:&nbsp;&nbsp;&nbsp;&nbsp;".$row["msg"]."</h3>";
	   				}
	  			  	echo "</div></li>";
	  			  	$date3 = $date;
	  			  	$date2 = $row["date"];
	  			  	$date = $date2;
  			  	}else{
  			  		echo "error on date and timelineID";
  			  	}
                }
            }catch(PDOException $ex){

            }
    }


    function updateSession($sess,$sid){
    	global $dbh;
    	try {
    		$session = $sess-1;
    		$query = $dbh->prepare("UPDATE student SET session=? WHERE studentID=?");
    		$passval= array($session,$sid);
    		$query->execute($passval);
    		
    	} catch (PDOException $e) {
    		
    	}
    }

      function addEmployeeTimeline($id,$msg,$time,$date,$icon){
	    	global $dbh;
	    	try{
		    	$query = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
				$passval = array(null,$id,$msg,$time,$date,$icon);
				$query -> execute($passval);
			}catch (PDOException $e) {
	
	    	}
	    }

	    function getLatestStudent(){
	    	global $dbh;
            try{
                                                                
                $query = $dbh->query("SELECT max(studentID) as `studID` FROM student");
                $query -> setFetchMode(PDO::FETCH_ASSOC);                                    

                $GLOBALS['studID'] = $dbh->lastInsertId();                                           
                                        
            }catch(PDOException $ex){
                echo $ex->getMessage();
            }         
 
	    }

		function updateSchedule($empID,$day,$time,$availability){
			global $dbh; 
			try {

				$query = $dbh -> prepare("UPDATE schedule SET availability = :availability 
										  WHERE day = :day AND employeeID = :empID AND time = :time ");
				$query -> bindParam(':empID',$empID);
				$query -> bindParam(':day',$day);
				$query -> bindParam(':time',$time);
				$query -> bindParam(':availability',$availability);
				$query -> execute(); 
				
			} catch (PDOException $ex) {
				echo $ex->getMessage();
			}

		}


function fetchRequests() {
			global $dbh;

			try {
				$query = $dbh -> query("SELECT CONCAT(e.firstName, ' ', e.lastName) as 'name', type, leaveID as `lid`, e.employeeid as `eid`, reason, startDate as 'sdate', endDate as 'edate', dateSent as 'ds' FROM leaves l JOIN employee e ON l.employeeid=e.employeeID WHERE l.affirmation = '0' ORDER BY dateSent");

				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()) {
					$modalTitle = str_replace(' ', '', $row['lid']);
					$acceptModal = str_replace(' ', '', 'accept'.$row['lid']);
					$declineModal = str_replace(' ', '', 'decline'.$row['lid']);

					$reason = htmlspecialchars(substr($row['reason'], 0, 150));
					$ds = date("F d, Y",strtotime($row['ds']));
					$st = date("F d, Y",strtotime($row['sdate']));
					$et = date("F d, Y",strtotime($row['edate']));

					$eid = $row['eid'];

					echo '<tr>';
					echo '<td><a href="#'.$modalTitle.'"> '.$reason.'</a></td>';
					echo '<td>'.$row['name'].'</td>';
					echo '<td>' .$st. ' - ' .$et. '</p></td>';
					echo '<td>'.$ds.'</td>';
					echo '</tr>';
					echo '<div id="'.$modalTitle.'" class="modalDialog"> 
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;">Message Body</h4>
                				</div>

                				<div class="modal-body">
                					
				                	<p><b>Employee Name:</b>'.$row['name'].'</p>
				                	<p><b>Start Date:</b>' .$st. ' &nbsp;&nbsp;&nbsp;<b>End Date:</b>' .$et. '</p>
				             		<p><b>Leave Type:</b>' .$row['type']. '</p>
				             		<p><b>Reason:<br></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .$reason. '</p>


					                <div style="text-align:center;">

					            		<a href="#'.$acceptModal.'"><button type="button" class="btn btn-info" style=" margin-top:20px; margin: 10px; float:left;">
					                        Accept
					                    </button></a>

					          			<a href="#'.$declineModal.'"><button type="button" class="btn btn-danger" style=" margin-top:10px; float:left;">
					                        Decline
					                    </button></a>

						   				<div class="modal-footer" style="margin-top:20px;">
					                		<a href="#close"><button class="btn btn-default" style=" margin-top:-10px;" type="button">Close</button></a>
					              		</div>
				              		</div>
				          		</div>
				          </div>
				        </div>';

				echo '   		<div id="'.$acceptModal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
   									<p><b>Leave Type:</b>' .$row['type']. '</p>
				                
				                </div>
								<div class="modal-body">
   									<p>Accept the leave request?</p>

   									<form action="includes/acceptLeave.php?id='.$row["lid"].'&eid='.$eid.'" method="POST">
					                	<label><span class="glyphicon glyphicon-star"></span> Entry Number: (in logbook)</label>
					                	<input style="display:inline;" type="number" class="form-control" name="en" id="entry" pattern="\d+" min="0" max="10000" placeholder="Enter a Number" required/>
					                	<label>Remarks:</label>
					                	<input type="text" class="form-control" rows="5" name="remarks" placeholder="What is the reason?" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required></input>
				                
				                </div>

				                <div class="modal-footer">
				                	<button class="btn btn-info" type="submit">DONE</button>
				                	</form>
				                	
				                	<a href=#'.$modalTitle.'><button class="btn btn-default" type="button">BACK</button></a>
				                </div>
				            </div>
				        </div>';

				echo '        <div id="'.$declineModal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
   									<p><b>Leave Type:</b>' .$row['type']. '</p>
				                
				                </div>
								<div class="modal-body">
   									<p>Decline the leave request?</p>

   									<form action="includes/declineLeave.php?id='.$row["lid"].'&eid='.$eid.'" method="POST">
					                	<label><span class="glyphicon glyphicon-star"></span> Entry Number: (in logbook)</label>
					                	<input style="display:inline;" type="number" class="form-control" name="en" id="entry" pattern="\d+" min="0" max="10000" placeholder="Enter a Number" required/>
					                	<label>Remarks:</label>
					                	<input type="text" class="form-control" rows="5" name="remarks" placeholder="What is the reason?" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required></input>
				                
				                </div>

				                <div class="modal-footer">
				                	<button class="btn btn-info" type="submit">DONE</button>
				                	</form>
				                	
				                	<a href=#'.$modalTitle.'><button class="btn btn-default" type="button">BACK</button></a>
				                </div>
				            </div>
				        </div>';
			
				}
			} catch (PDOException $ex) {
				echo $ex -> getMessage();
			}
		}//fetchRequests



function leaveReports() {
			global $dbh;

			try {
				$query = $dbh -> query("SELECT CONCAT(e.firstName, ' ', e.lastName) as 'name', type, leaveID as `lid`, e.employeeid, reason, startDate as 'sdate', endDate as 'edate',affirmation,dateSent as 'ds', dateAffirm as `da` FROM leaves l JOIN employee e ON l.employeeid=e.employeeID WHERE affirmation = '1' OR affirmation = '2'");

				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()) {
					$modalTitle = str_replace(' ', '', $row['lid']);
					$declineModal = str_replace(' ', '', 'decline'.$row['lid']);

					$reason = substr($row['reason'], 0, 150);
					$ds = date("F d, Y",strtotime($row['ds']));
					$st = date("F d, Y",strtotime($row['sdate']));
					$et = date("F d, Y",strtotime($row['edate']));					
					$affirm = $row['affirmation'];					
					$da = date("F d, Y",strtotime($row['da']));

					echo '<tr>';
					echo '<td><a href="#'.$modalTitle.'">'.$reason.'</a></td>';
					echo '<td>'.$row['name'].'</td>';
					echo '<td>'.$st.' - '.$et.'</td>';
					echo '<td>'.$da.'</td>';
					if($affirm == '1'){
						echo '<td><span class="badge bg-blue">Accepted</span></td>';
					}else if($affirm == '2'){
						echo '<td><span class="badge bg-red">Declined</span></td>';
					}
					
					echo '</tr>';
					echo '<div id="'.$modalTitle.'" class="modalDialog"> 
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;">Message Body</h4>
                				</div>

                				<div class="modal-body">
                					
				                	<p><b>Employee Name:</b>'.$row['name'].'</p>
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


function leaveReportsAccepted() {
			global $dbh;

			try {
				$query = $dbh -> query("SELECT CONCAT(e.firstName, ' ', e.lastName) as 'name', type, leaveID as `lid`, e.employeeid, reason, startDate as 'sdate', endDate as 'edate',affirmation,dateSent as 'ds' FROM leaves l JOIN employee e ON l.employeeid=e.employeeID WHERE affirmation = '1'");

				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()) {
					$modalTitle = str_replace(' ', '', $row['lid']);
					$declineModal = str_replace(' ', '', 'decline'.$row['lid']);

					$reason = substr($row['reason'], 0, 150);
					$ds = date("F d, Y",strtotime($row['ds']));
					$st = date("F d, Y",strtotime($row['sdate']));
					$et = date("F d, Y",strtotime($row['edate']));
					$affirm = $row['affirmation'];

					echo '<tr>';
					echo '<td><a href="#'.$modalTitle.'">'.$reason.'</a></td>';
					echo '<td>'.$row['name'].'</td>';
					echo '<td>'.$st.' - '.$et.'</td>';
					if($affirm == '1'){
						echo '<td><span class="badge bg-blue">Accepted</span></td>';
					}else if($affirm == '2'){
						echo '<td><span class="badge bg-red">Declined</span></td>';
					}
					
					echo '</tr>';
					echo '<div id="'.$modalTitle.'" class="modalDialog"> 
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;">Message Body</h4>
                				</div>

                				<div class="modal-body">
                					
				                	<p><b>Employee Name:</b>'.$row['name'].'</p>
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
		}//leaveReportsAccepted


function leaveReportsDeclined() {
			global $dbh;

			try {
				$query = $dbh -> query("SELECT CONCAT(e.firstName, ' ', e.lastName) as 'name', type, leaveID as `lid`, e.employeeid, reason, startDate as 'sdate', endDate as 'edate',affirmation,dateSent as 'ds' FROM leaves l JOIN employee e ON l.employeeid=e.employeeID WHERE affirmation = '2'");

				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()) {
					$modalTitle = str_replace(' ', '', $row['lid']);
					$declineModal = str_replace(' ', '', 'decline'.$row['lid']);

					$reason = substr($row['reason'], 0, 150);
					$ds = date("F d, Y",strtotime($row['ds']));
					$st = date("F d, Y",strtotime($row['sdate']));
					$et = date("F d, Y",strtotime($row['edate']));
					$affirm = $row['affirmation'];

					echo '<tr>';
					echo '<td><a href="#'.$modalTitle.'">'.$reason.'</a></td>';
					echo '<td>'.$row['name'].'</td>';
					echo '<td>'.$st.' - '.$et.'</td>';
					if($affirm == '1'){
						echo '<td><span class="badge bg-blue">Accepted</span></td>';
					}else if($affirm == '2'){
						echo '<td><span class="badge bg-red">Declined</span></td>';
					}
					
					echo '</tr>';
					echo '<div id="'.$modalTitle.'" class="modalDialog"> 
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;">Message Body</h4>
                				</div>

                				<div class="modal-body">
                					
				                	<p><b>Employee Name:</b>'.$row['name'].'</p>
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
		}//leaveReportsDeclined
	
		function studentTimeline($id,$tutor,$fname,$lname,$classID){
			global $dbh;
			date_default_timezone_set('Asia/Manila');
		    $time = date("h:i");
		    $date = date("Y-m-d");
		    $icon = "fa fa-book bg-blue";
			$query = $dbh->query("SELECT skillName as `sk` FROM skills WHERE skillID='$classID'");
			while($row=$query->fetch()){
				$classname = $row['sk'];

				$query2 = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `tutor` FROM employee WHERE employeeID='$tutor'");
				while($row2 = $query2->fetch()){
					$name = $row2['tutor'];
					$msg = '<b>'.$fname.' '.$lname.'</b> enrolled <b>'.$classname.'</b> (Tutor: <b>'.$name.'</b>)';
					
					$query3 = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
					$passval = array(null,$id,$msg,$time,$date,$icon);
					$query3 -> execute($passval);

				}

			}

		}

		function substituteTimeline($tid,$id,$eid){
			global $dbh;
			try{
				date_default_timezone_set('Asia/Manila');
				$time = date("h:i");
				$date = date("Y-m-d");
				$icon = "fa fa-book bg-yellow";

				$query = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `name` FROM employee WHERE employeeID='$eid'");
					while($row = $query->fetch()){
						$name = $row['name'];
						$msg = '<b>'.$name.'</b> substituted to a class.';
						$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
						$passval = array(null,$id,$msg,$time,$date,$icon);
						$timeline -> execute($passval);
					}

			}catch(PDOException $e){

			}
		}

function fetchnotif($id){
        global $dbh;
        $query = $dbh -> prepare('SELECT b.firstName AS `fn` , a.notifID AS  `id` , a.sender AS  `sndr` , a.reciever AS  `rcvr` , a.msg AS  `msg` , a.status, a.link as `link` 
        FROM notification a
        INNER JOIN employee b ON a.sender = b.employeeID
        WHERE a.status =  "Unseen"
        AND a.reciever = :id
        ORDER BY a.notifID DESC LIMIT 6');
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
                        		if($row['sndr'] == "174"){
                        			echo "</a>
						                  <ul class='dropdown-menu'>
						                  <li class='header'>You have ".$row2["count"]." notifications</li>
						                  <li>
						                  <ul class='menu'><li>
			                      		  <a href='".$row['link']."?nt=".$row['id']."'>
			                      		  <i class='ion ion-ios7-people info'></i>A Customer&nbsp;".$row["msg"]."</a>
			                      		  </li>";
			                      		  $temp = 2;
                        			}else{
				                          echo "</a>
						                  <ul class='dropdown-menu'>
						                  <li class='header'>You have ".$row2["count"]." notifications</li>
						                  <li>
						                  <ul class='menu'><li>
			                      		  <a href='".$row['link']."?nt=".$row['id']."'>
			                      		  <i class='ion ion-ios7-people info'></i>".$row["fn"]."&nbsp;".$row["msg"]."</a>
			                      		  </li>";
			            				  $temp = 2;}
            				}elseif($row2["count"] > 0){
            				  if($row['sndr'] == "174"){
                        			echo "<span class='label label-warning'>".$row2["count"]."</span></a>
						                  <ul class='dropdown-menu'>
						                  <li class='header'>You have ".$row2["count"]." notifications</li>
						                  <li>
						                  <ul class='menu'><li>
			                      		  <a href='".$row['link']."?nt=".$row['id']."'>
			                      		  <i class='ion ion-ios7-people info'></i>A Customer&nbsp;".$row["msg"]."</a>
			                      		  </li>";
			                      		  $temp = 2;
                        			}else{
				                          echo "<span class='label label-warning'>".$row2["count"]."</span></a>
						                  <ul class='dropdown-menu'>
						                  <li class='header'>You have ".$row2["count"]." notifications</li>
						                  <li>
						                  <ul class='menu'><li>
			                      		  <a href='".$row['link']."?nt=".$row['id']."'>
			                      		  <i class='ion ion-ios7-people info'></i>".$row["fn"]."&nbsp;".$row["msg"]."</a>
			                      		  </li>";
			            				  $temp = 2;}
            				}else{

            				}
                        }elseif($temp > 1){
                            if($row['sndr'] == "174"){
                        			echo "<li>
			                      		  <a href='".$row['link']."?nt=".$row['id']."'>
			                      		  <i class='ion ion-ios7-people info'></i>A Customer&nbsp;".$row["msg"]."</a>
			                      		  </li>";
			                      		  $temp = 2;
                        			}else{
				                          echo "<li>
			                      		  <a href='".$row['link']."?nt=".$row['id']."'>
			                      		  <i class='ion ion-ios7-people info'></i>".$row["fn"]."&nbsp;".$row["msg"]."</a>
			                      		  </li>";
			            				  $temp = 2;}
                        }else{
                                echo "<script>alert('may mali')</script>";
                        }

            }
        }catch(PDOException $ex){

        }
}

function deleteEmployeeTimeline($delete,$uid){
	global $dbh;
	date_default_timezone_set('Asia/Manila');
	$time = date("h:i");
	$date = date("Y-m-d");
	$icon = "fa fa-user bg-red";

	try {
		$query = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `name` FROM employee WHERE employeeID='$delete'");
		while($row = $query->fetch()){
			$name = $row['name'];
			$msg = '<b>'.$name.'</b> has been deleted from the employee list';
			$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
			$passval = array(null,$uid,$msg,$time,$date,$icon);
			$timeline -> execute($passval);
		}
	} catch (PDOException $e) {
		
	}
}

function editProfileTimeline($id,$msg,$time,$date,$icon){
	    	global $dbh;
	    	try{
		    	$query = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
				$passval = array(null,$id,$msg,$time,$date,$icon);
				$query -> execute($passval);
			}catch (PDOException $e) {
	
	    	}
	    }
	

};


$db = new MySQLDB;

?>