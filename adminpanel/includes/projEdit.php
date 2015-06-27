<?php 
	include_once "database.php";
	echo $db -> ifLogin();
  	$id = $_SESSION['empID'];
	



	$projid = $_GET['id'];


			$projTitle= $_POST['projectTitle'];
            $name= $_POST['cName'];
            $phone= $_POST['contactnumber'];
            $projLoc= $_POST['projectLocation'];
            $totalNoHours= $_POST['hours'];
            $hoursInMin = $totalNoHours * 60;

            $skill= $_POST['skillreq'];

            //$sDate= $_POST['startDate'];
           // $dDate= $_POST['dueDate'];

            $dates = $_POST['dates'];
            $d = explode("-", $dates);
            $start = strtotime($d[0]);
            $due= strtotime($d[1]);
            $sDate = date('Y-m-d',$start);
            $dDate = date('Y-m-d',$due);

            $status = "ongoing";
            date_default_timezone_set('Asia/Manila');
            $time = date("h:i");
            $date = date("Y-m-d");
            $msg = "<b>PROJECT: " .$projTitle."</b> has been edited.";
            $icon = "fa fa-briefcase bg-blue";

            if($sDate > $dDate){
                echo '<script>window.location="../assignDraftsman.php?s=date";</script>';
            }else{
            	try {
					date_default_timezone_set('Asia/Manila');
								    $time = date("h:i");
								    $date = date("Y-m-d");
								    $icon = "fa fa-briefcase bg-green";
								    $query = $dbh->query("SELECT projectName as `pn` FROM project WHERE projectID = '$projid'");
								    while($row = $query->fetch()){
								    	$project = $row['pn'];
								    	$msg = "<b>".$project.'</b> has been edited.';
								    	$timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
										$passval = array(null,$id,$msg,$time,$date,$icon);
										$timeline -> execute($passval);
								    }

					$query = $dbh->prepare("UPDATE project SET projectName=:pn, clientName=:client, contactNum=:contact, location=:location,
										totalNumHours=:totalNoHours, skillReq=:skill, startdate=:sDate, duedate=:dDate WHERE projectID=:pid");
									$query -> bindParam(":pn",$projTitle);
									$query -> bindParam(":client",$name);
									$query -> bindParam(":contact",$phone);
									$query -> bindParam(":location",$projLoc);
									$query -> bindParam(":totalNoHours",$hoursInMin);
									$query -> bindParam(":skill",$skill);
									$query -> bindParam(":sDate",$sDate);
									$query -> bindParam(":dDate",$dDate);

									$query -> bindParam(":pid",$projid);
									$query -> execute();
									echo "<script>window.location='../assignDraftsman.php?s=ed';</script>";
					
				} catch (PDOException $e) {
					
				}
                
            }


	
	





?>