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
          else if ($_SESSION['type'] == "draftsman" || $_SESSION['type'] == "Draftsman"){
	           $query2 = $dbh->prepare("SELECT id, proj_id as `pid`, status as `to` FROM projwork WHERE eID = ? AND `id` = (SELECT MAX(id) ) ORDER BY id DESC LIMIT 1");
	           $passval2= array($queryUser);
	           $query3 = $dbh->prepare("SELECT COUNT(timeOut) as `count` FROM projwork WHERE eID = ? AND `id` = (SELECT MAX(id) ) ORDER BY id DESC LIMIT 1");
	           $query2 ->execute($passval2);
	           $query3 ->execute($passval2);
	           $row2 = $query2 ->fetch();
	           $row3 = $query3 ->fetch();
	           $timout = $row2['to'];
	           $count = $row3['count'];
			   
	           if($timout == NULL){
	                echo '<script>windows: location="draftsmanpanel/index.php"</script>';
	           }elseif($timout == 1){
	           		echo '<script>windows: location="draftsmanpanel/index2.php?pid='.$row2['pid'].'"</script>';
	           }elseif($count == 0){
	           		echo '<script>windows: location="draftsmanpanel/index.php"</script>';
	           }else{
	           		echo '<script>windows: location="draftsmanpanel/index.php"</script>';
	           }
          
          }
            else if ($_SESSION['type'] == "tutorial" || $_SESSION['type'] == "Tutorial")
          {
            $query = $dbh->prepare("SELECT type FROM account WHERE type=? ");

                echo '<script>windows: location="tutorialpanel/index.php"</script>';
          }
            else if ($_SESSION['type'] == "Draftsman/Tutor" || $_SESSION['type'] == "draftsman/tutor")
          {
            $query = $dbh->prepare("SELECT type FROM account WHERE type=? ");

	           $query2 = $dbh->prepare("SELECT id, status as `to` FROM projwork WHERE eID = ? AND `id` = (SELECT MAX(id) ) ORDER BY id DESC LIMIT 1");
	           $passval2= array($queryUser);
	           $query3 = $dbh->prepare("SELECT COUNT(timeOut) as `count` FROM projwork WHERE eID = ? AND `id` = (SELECT MAX(id) ) ORDER BY id DESC LIMIT 1");
	           $query2 ->execute($passval2);
	           $query3 ->execute($passval2);
	           $row2 = $query2 ->fetch();
	           $row3 = $query3 ->fetch();
	           $timout = $row2['to'];
	           $count = $row3['count'];
			   
	           if($timout == NULL){
	                echo '<script>windows: location="dualtypepanel/index.php"</script>';
	           }elseif($timout == 1){
	           		echo '<script>windows: location="dualtypepanel/projects2.php"</script>';
	           }elseif($count == 0){
	           		echo '<script>windows: location="dualtypepanel/index.php"</script>';
	           }else{
	           		echo '<script>windows: location="dualtypepanel/index.php"</script>';
	           }
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


		function addEmployee($fname, $lname, $address, $contact, $email, $birthdate){
			global $dbh;
			try{
				$query = $dbh -> prepare("INSERT INTO employee(firstName,lastName,contactNum,address,email,bday) VALUES (:fname,:lname,:contact,:address,:email,:birthdate)");
				$query -> bindParam(':fname',$fname);
				$query -> bindParam(':lname',$lname);
				$query -> bindParam(':contact',$contact);
				$query -> bindParam(':address',$address);
				$query -> bindParam(':email',$email);
				$query -> bindParam(':birthdate',$birthdate);
				$query -> execute();
			}catch(PDOException $e){
				echo $ex->getMessage();
			}

		}//addEmployee

		function addProject($projTitle,$name,$phone,$projLoc,$totalNoHours,$sDate,$dDate){
		    global $dbh;
		    $query= $dbh->prepare("INSERT INTO project VALUES (?,?,?,?,?,?,?,?)");
		    $passval= array('345345',$projTitle,$name,$phone,$projLoc,$totalNoHours,$sDate,$dDate);
		      try{
		        $query->execute($passval);
		        
		        // echo "<script> window.location='empLoan.php' </script>";
		        echo "<script>alert('Add Project successful')</script>";
		        die();
		      }catch(PDOException $ex){
		        echo $ex->getMessage();
		        die();
		      }
		  }//addproject


		function fetchProjects(){
			global $dbh;

			try{
				/*$query = $dbh->query("SELECT * FROM project p 
					JOIN client c ON p.clientID = c.clientID
					JOIN employee e ON p.employeeID = e.employeeID;");*/
				$query = $dbh->query("SELECT * FROM
									(SELECT projectName as `pn`,
									CONCAT(c.firstName,' ', c.lastName) as `client`, 
									CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
									location, duedate,
									TIMESTAMPDIFF(HOUR, NOW(), duedate) as `due`
									FROM project p 
									JOIN client c ON p.clientID = c.clientID
									JOIN employee e ON p.employeeID = e.employeeID) as `tablename`
									WHERE due >0;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					$modalTitle = str_replace(' ', '', $row['pn']);
					echo '<tr>';
					echo '<td><a href="#'.$modalTitle.'">'.$row['pn'].'</a></td>';
					echo '<td>'.$row['draftsman'].'</td>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$row['client'].'</td>';
					echo '<td>'.$row['duedate'].'</td>';
					echo '<td>'.$row['due'].' hrs</td>';
					echo '</tr>';
					//MODAL
					echo '<div id="'.$modalTitle.'" class="modalDialog">
							<div>
                				<a href="#close" title="Close" class="close">X</a>
                
				                <h2 style="text-align:center;">' .$row['pn']. '</h2>
				                <p><b>Location: </b>'.$row['location'].'</p>
				                <p><b>Remaining Time Left:</b>' .$row['due']. ' hrs</p>
				                <p><b>Due Date:</b> '.$row['duedate'].'</p>
				                <div style="text-align:center;">
				                    <a href="#extendModal"><button class="btn btn-success" style="width:200px; height:50px;">
				                        Extend Project
				                    </button></a><br><br>
				                    <button class="btn btn-success" style="width:200px; height:50px;">
				                        Hold Project
				                    </button><br><br>
				                    <button class="btn btn-success" style="width:200px; height:50px;">
				                        Finish Project
				                    </button><br><br>
				                    <button class="btn btn-success" style="width:200px; height:50px;">
				                        Cancel Project
				                    </button>
				                </div>
				            </div>
				        </div>';
				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}
		}//fetchProjects


		function fetchEmployees(){
			global $dbh;
			try{
				$query = $dbh -> query("SELECT employeeID as `eid`,
					CONCAT(e.firstName, ' ', e.lastName) as `name`,
					email, type, password, username, skillName as `sn`
					FROM employee e 
					JOIN skills s ON e.skill = s.skillID
					JOIN account a ON e.employeeID = a.empID");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				while($row = $query->fetch()){
					echo '<tr>';
					echo '<td>'.$row['eid'].'</td>';
					
					echo '<td>';
					echo '<img src="img/users/'.$row['eid'].'.jpg" width="100px" height="100px">';
					echo '</td>';
					
					echo '<td>'.$row['name'].'</td>';
					echo '<td>'.$row['email'].'</td>';

					if($row['type']==1){
						echo '<td>Draftsman</td>';
					} else if ($row['type']==2){
						echo '<td>Tutor</td>';
					}

					echo '<td>'.$row['sn'].'</td>';
					
					echo '<td>
							<a href="#'.$row["eid"].'"">
								<button class="btn btn-info">
									Edit
                                </button>
                            </a>
                        </td>';

                    echo '<td>
                    		<a href="#del'.$row['eid'].'">
                    			<button class="btn btn-danger">
                                    Delete
                                </button>
                            </a>
                        </td>';
					
					echo '</tr>';

					#MODAL EDIT USERNAME PASSWORD
					echo '<div id="'.$row['eid'].'" class="modalDialog">
				            <div>
				                <a href="#close" title="Close" class="close">X</a>
				                <h2>Edit Information</h2>
				                <form method="POST">
				                		<input name="empid" type="hidden" value="'.$row['eid'].'">
					                <p>Username
					                    <input name= "username" type="text" value="'.$row['username'].'">
					                </p>

					                <p>Password
					                    <input name= "password" type="password" value="'.$row['password'].'"">
					                </p>
					                
					                   <input type="submit" name="save" value = "Save" class="btn btn-success">
					            </form>

				                <a href="#close" class="close"><button class="btn btn-danger">
				                    Cancel
				                </button></a>
				            </div>
				        </div>';

				    #MODAL DELETE    
				     echo ' <div id="del'.$row['eid'].'" class="modalDialog">
					            <div>
					                <a href="#close" title="Close" class="close">X</a>
					                <h2>Delete</h2>
					                
					                <p>Are you sure?</p>
					                <button class="btn btn-success">
					                    Yes
					                </button>

					                <a href="#close" class="close"><button class="btn btn-danger">
				                    	Cancel
				                	</button></a>
					            </div>
					        </div>';
				}//while

				//edit username password
				if(isset($_POST['save'])){
					$uname = $_POST['username'];
					$password = $_POST['password'];
					$empid = $_POST['empid'];

					$query = $dbh ->prepare("UPDATE account SET username=:uname, password=:password WHERE empID=:empid");
					$query -> bindParam(':uname',$uname);
					$query -> bindParam(':password',$password);
					$query -> bindParam(':empid',$empid);
					$query -> execute();
					echo '<script>window.location="listOfEmployees.php"; alert("Account updated."); </script>';

				}

			

			}catch(PDOException $e){
				echo $ex->getMessage();
			}

		}//fetchEmployees

		function reports(){
			global $dbh;

			try{
				$query = $dbh->query("SELECT employeeID as `eid`, firstName as 'fn', lastName as 'ln'
										FROM employee;
									");
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				
				while($row = $query->fetch()){
					$id = $row['eid'];
					
					#count accomplished
					$query2 = $dbh->query("SELECT COUNT(*) as 'accomplished' FROM
										(SELECT e.employeeID as `eid`, duedate,
										TIMESTAMPDIFF(HOUR, NOW(), duedate) as `due`
										FROM project p 
										JOIN employee e ON p.employeeID = e.employeeID) as `tablename`
									WHERE due < 0 AND eid=$id ;");
					$query2 -> setFetchMode(PDO::FETCH_ASSOC);
					
					while($row2 = $query2->fetch()){
						#count ongoing
						$query3 = $dbh->query("SELECT COUNT(*) as 'ongoing' FROM
										(SELECT e.employeeID as `eid`, duedate,
										TIMESTAMPDIFF(HOUR, NOW(), duedate) as `due`
										FROM project p 
										JOIN employee e ON p.employeeID = e.employeeID) as `tablename`
									WHERE due > 0 AND eid=$id ;");

						$query3 -> setFetchMode(PDO::FETCH_ASSOC);
							while($row3 = $query3->fetch()){

					
					
								echo '<tr>';

								echo '<td><img src="img/users/'.$id.'.jpg" width="100px" height="100px"></td>';
								echo '<td>'.$row['fn'].' '.$row['ln'].'</td>';
								echo '<td><a href=accomplished.php?id='.$id.'>'.$row2['accomplished'].'</a></td>';
								echo '<td><a href=ongoing.php?id='.$id.'>'.$row3['ongoing'].'</td>';

								echo '</tr>';
						}//3rd while
					}//2nd while
				}//1st while
			}catch(PDOException $ex){
				echo $ex->getMessage();
			}


		}//reports()


		function fetchAccomplished(){
			global $dbh;

			$param = $_GET['id'];
			
			try{
				$query = $dbh -> query("SELECT * FROM
					(SELECT e.employeeID as `eid`, projectName as `pn`,
					CONCAT(c.firstName,' ', c.lastName) as `client`, 
					CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
					location, duedate,
					TIMESTAMPDIFF(HOUR, NOW(), duedate) as `due`
					FROM project p 
					JOIN client c ON p.clientID = c.clientID
					JOIN employee e ON p.employeeID = e.employeeID) as `tablename`
				WHERE due < 0 AND eid='$param' ;");
				
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				
				while($row = $query->fetch()){
					echo '<tr>';
					echo '<td>'.$row['pn'].'</td>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$row['client'].'</td>';
					echo '</tr>';
				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}

		}//fetchAccomplished


		function fetchOngoing(){
			global $dbh;

			$param = $_GET['id'];
			
			try{
				$query = $dbh -> query("SELECT * FROM
					(SELECT e.employeeID as `eid`, projectName as `pn`,
					CONCAT(c.firstName,' ', c.lastName) as `client`, 
					CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
					location, duedate,
					TIMESTAMPDIFF(HOUR, NOW(), duedate) as `due`
					FROM project p 
					JOIN client c ON p.clientID = c.clientID
					JOIN employee e ON p.employeeID = e.employeeID) as `tablename`
				WHERE due > 0 AND eid='$param' ;");
				
				$query -> setFetchMode(PDO::FETCH_ASSOC);
				
				while($row = $query->fetch()){
					echo '<tr>';
					echo '<td>'.$row['pn'].'</td>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$row['client'].'</td>';
					echo '</tr>';
				}


			}catch(PDOException $ex){
				echo $ex->getMessage();
			}

		}//fetchAccomplished

		function insertFeedback($first, $last, $email, $message){
			global $dbh;

			try {
				$query = $dbh -> prepare("INSERT INTO feedbacks() VALUES (':first,:last,:email,:message');");
				$query -> bindParam(':first',$first);
				$query -> bindParam(':last',$last);
				$query -> bindParam(':email',$email);
				$query -> bindParam(':message',$message);
				$query -> execute();
				
			} catch (PDOException $e) {
				
			}

		}


		function getInquiry($fname,$lname,$emailAdd,$sendMessage){
		    global $dbh;
		    $query= $dbh->prepare("INSERT INTO inquiries VALUES (?,?,?,?,?)");
		    $passval= array(null,$fname,$lname,$emailAdd,$sendMessage);
		      try{
		        $query->execute($passval);
		        
		        // echo "<script> window.location='empLoan.php' </script>";
		        echo "<script>alert('Inquiry Sent')</script>";
		        die();
		      }catch(PDOException $ex){
		        echo $ex->getMessage();
		        die();
		      }
		}

		

};

$db = new MySQLDB;

?>