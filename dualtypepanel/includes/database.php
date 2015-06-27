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
                 echo "<script>window.location='empProfile.php?s=updated'</script>";

            } catch (PDOException $e) {
                echo $e->getMessage();
                die();  
            }
        }




		
		function applyLeave($id, $newstart, $newend,$dateSent, $reason, $affirm, $type){
            global $dbh;

			try {
				$rcv = "174";
                $msg = "applied for leave";
                $stat = "Unseen";
                $link = "requests2.php";
				$query = $dbh -> prepare("INSERT INTO leaves VALUES(?,?,?,?,?,?,?,?,?,?,?);");
                $passval = array(null,$id,$newstart,$newend,$dateSent,$reason,$affirm,$type,null,null,null);
                $query -> execute($passval);
                echo "<script>window.location='applyLeave.php?s=success'</script>";

                $notif = $dbh->prepare("INSERT INTO notification VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$rcv,$msg,$stat,$link);
                $notif -> execute($passval);

                date_default_timezone_set('Asia/Manila');
                $time = date("h:i");
                $date = date("Y-m-d");
                $icon = "fa fa-plus-square bg-red";
                $msg = '<b>LEAVE APPLICATION:</b> '.$remarks;
                $timeline = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$msg,$time,$date,$icon);
                $timeline -> execute($passval);

                 echo "<script>window.location='applyLeave.php?s=success'</script>";

			} catch (PDOException $e) {
				echo $e->getMessage();
	        	die();
			}


        }

		function ifLogin(){
    		session_start();
      		if(!isset($_SESSION['type']))
      		{
      			echo '<script>windows: location="../login.php";</script>';
      		}
  		}//iflogin


		function fetchOngoingProjects($id){
        try{
                global $dbh;
                $query = $dbh -> prepare('SELECT projectID as `pid`, 
                    projectName as `pn`,   
                    duedate as `dd`,
                    FLOOR(totalNumHours/60) as `h`,
                    MOD(totalNumHours, 60) as `m`
                    FROM project 
                    WHERE draftsmanID = :id
                    AND status = "ongoing"'); 
                $query -> bindParam(':id',$id);
                $query->execute();

       
                while($row = $query -> fetch() ) {
                    if(STRLEN($row['m']) > 2){
                         $row['m'] = substr($row['m'], 0, 2);
                    }
                    $d = date("F d, Y",strtotime($row['dd']));
                    echo "<tr>";
                    echo "<td>".$row['pn']."</td>";
                    echo "<td>".$d."</td>";
                    echo "<td>".$row['h']." hours and ".$row['m']." minutes</td>";
                    echo '<td><a href="viewLogs2.php?id='.$row['pid'].'"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><span class="glyphicon glyphicon-stats"></span> View Logs</button></a></td>';
                    echo '</tr>';
                }
            }catch(PDOException $ex){

            }
        }



	function fetchAccomplishedProjects($id){
		try{
				global $dbh;
                $query = $dbh -> prepare('SELECT projectID as `pid`, 
                	projectName as `pn`,  
                	location as `l`, 
                	duedate as `dd`,
                	status as `s` 
                	FROM project
                	WHERE draftsmanID = :id
                	AND status = "completed"'); 
                $query -> bindParam(':id',$id);
                $query->execute();    

        
                while($row = $query -> fetch() ) {
                    echo "<tr>";
                    echo "<td>".$row['pn']."</td>";
                    echo "<td>".$row['l']."</td>";
                    echo "<td>".$row['dd']."</td>";
                    echo "<td>".$row['s']."</td>";
                    echo "</tr>";
                }
            }catch(PDOException $ex){

            }
		}



	function fetchListOfMyProjects($id){
		try{
				global $dbh;
                $query = $dbh -> prepare('SELECT projectID as `pid`, 
                	projectName as `pn`, 
                	clientName as `cn`,
                	contactNum as `cnum`, 
                	location as `l`, 
                	startdate as `sd` , 
                	duedate as `dd` 
                	FROM project
                	WHERE draftsmanID = :id'); 
                $query -> bindParam(':id',$id);
                $query->execute();

        
                while($row = $query -> fetch() ) {
                    echo "<tr>";
                    echo "<td>".$row['pid']."</td>";
                    echo "<td>".$row['pn']."</td>";
                    echo "<td>".$row['cn']."</td>";
                    echo "<td>".$row['cnum']."</td>";
                    echo "<td>".$row['l']."</td>";
                    echo "<td>".$row['sd']."</td>";
                    echo "<td>".$row['dd']."</td>";
                    echo "</tr>";
                }
            }catch(PDOException $ex){

            }
	}

		function fetchProjects($id){
        try{
                global $dbh;
                $query = $dbh -> prepare('SELECT projectID as `pid`, 
                    projectName as `pn` 
                    FROM project
                    WHERE draftsmanID = :id
                    AND status = "ongoing"'); 
                $query -> bindParam(':id',$id);
                $query->execute();
                while($row = $query -> fetch() ) {
                echo "<option value='".$row['pid']."'>".$row['pn']."</option>";
                }
            }catch(PDOException $ex){

            }
    }



            function fetchProjectReport($id){
            global $dbh;

            try{
                $query = $dbh->query("SELECT * FROM
                                    (SELECT projectName as `pn`, projectID as `pid`,
                                    clientName as `client`, skillName as `sn`,
                                    CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
                                    location,
                                    status, duedate, startdate,
                                    p.remarks as `remarks`,
                                    totalNumHours as `due`, p.contactNum as `contact`
                                    FROM project p 
                                    JOIN employee e ON p.draftsmanID = e.employeeID
                                    JOIN skills s ON p.skillReq = s.skillID
                                    WHERE e.employeeID ='$id'
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
                    
                    $query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
                                    ");
                    $row2 = $query2->fetch();

                    $h = floor($row2['consumed'] / 60);
                    $m = ($row2['consumed'] % 60);
                    
                    echo '<tr>';
                    echo '<td><a href=#'.$modal.'><b>'.$row['pn'].'</b></a></td>';
                    echo '<td>'.$row['draftsman'].'</td>';
                    echo '<td>'.$row['sn'].'</td>';
                    echo '<td>'.$row['location'].'</td>';
                    if($row['status'] == 'ongoing'){
                        echo "<td style='text-align:center;'><span class='badge bg-blue'>".$row['status']."</span></td>";
                    }else if($row['status'] == 'cancelled'){
                        echo "<td style='text-align:center;'><span class='badge bg-red'>".$row['status']."</span></td>";
                    }else if($row['status'] == 'finished'){
                        echo "<td style='text-align:center;'><span class='badge bg-yellow'>".$row['status']."</span></td>";
                    }else if($row['status'] == 'hold'){
                        echo "<td style='text-align:center;'><span class='badge bg-green'>".$row['status']."</span></td>";
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
                                    
                                    <p><b>Start Date:</b>' .$row['sdate']. ' &nbsp;&nbsp;&nbsp;<b>End Date:</b>' .$row['edate']. '</p>
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

        function fetchLogs($pid){
            global $dbh;
            

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
        function fetchProjectReportOngoing($id){
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
                                    WHERE e.employeeID ='$id'
                                    AND status = 'ongoing') as `tablename`
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

        function fetchProjectReportFinished($id){
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
                                    WHERE e.employeeID ='$id'
                                    AND status = 'finished') as `tablename`
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

                    $status = $row['status'];
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
                                    
                                   <div style="text-align:center;">
                                        <p><b>ENTRY NUMBER</b>: '.$row['fn'].'</p>
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
                                        echo '<p><b>REMARKS</b>: '.$row['remarks'].'</p>';

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

function fetchProjectReportHold($id){
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
                                    WHERE e.employeeID ='$id'
                                    AND status = 'hold') as `tablename`
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
                                    
                                   <div style="text-align:center;">
                                        <p><b>ENTRY NUMBER</b>: '.$row['hn'].'</p>
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
                                        echo '<p><b>REMARKS</b>: '.$row['remarks'].'</p>';

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

        function fetchProjectReportCancelled($id){
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
                                    WHERE e.employeeID ='$id'
                                    AND status = 'cancelled') as `tablename`
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
                                    
                                   <div style="text-align:center;">
                                        <p><b>ENTRY NUMBER</b>: '.$row['cn'].'</p>
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
                                        echo '<p><b>REMARKS</b>: '.$row['remarks'].'</p>';

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

  function timeIn($id,$choice,$date1,$date2,$timeIN,$timeOUT,$pid){
    global $dbh;
    date_default_timezone_set('Asia/Manila');
    $time=date('G:i A');
    $temp=1;
    $query= $dbh->prepare("INSERT INTO projwork VALUES (?,?,?,?,?,?,?,?)");

    if($timeIN == NULL || $timeOUT == NULL){
        $passval = array(null,$id,$choice,$time,null,null,$date1,$temp);
        $temp2=0;
    }else{
        $passval = array(null,$id,$choice,$timeIN,$timeOUT,null,$date1,$temp);
        $temp2=1;
    }
      try{
        $query->execute($passval);
        $this->timelineTimeIn($id,$choice,$date1,$time);
        if($temp2 == 0){
            echo "<script>window.location='projects2.php?s=timein&pid=".$pid."';</script>";
            die();
        }else{
            $query2= $dbh->prepare("UPDATE projwork SET `hrWork` = (SELECT TIMESTAMPDIFF(minute, CONCAT(?,' ',timeIn), CONCAT(?,' ',timeOut))), status = NULL WHERE `eID`= ? AND `proj_id` = ? AND `id` = (SELECT MAX(id))");
            $passval2 = array($date1,$date2,$id,$choice);
            $query2->execute($passval2);
            $query3 = $dbh -> query("SELECT hrWork as `hw` FROM projwork WHERE id=(SELECT MAX(id) FROM projwork) AND proj_id='$choice' AND eID='$id'");
            $query3 -> execute();
            while($row = $query3->fetch()){
                $hw = $row['hw'];
                $query4 =  $dbh -> prepare("UPDATE project SET totalNumHours=(totalNumHours-(?)) WHERE projectID=?");
                $passval4 = array($hw,$choice);
                $query4 -> execute($passval4);
            }
            $query9 =  $dbh -> prepare("UPDATE project SET totalNumHours = 0 WHERE totalNumHours < 0");
            $query9 -> execute();
            echo "<script>window.location='projects.php?s=timein';</script>";
            die();
        }
      }catch(PDOException $ex){
        die();
      }
  }

  function timeOut($id,$choice){
    global $dbh;
    date_default_timezone_set('Asia/Manila');
    $date=date('Y-m-d');
    $time=date('G:i A');
    $temp=NULL;
    $query= $dbh->prepare("UPDATE projwork SET `timeOut` =?, `status`=? WHERE `eID`= ? AND `proj_id` = ? AND `timeOut` is NULL");
    $passval= array($time,$temp,$id,$choice);
    
 
    
      try{
        $query->execute($passval);

        $query2= $dbh->prepare("UPDATE projwork SET `hrWork` = (SELECT TIMESTAMPDIFF(minute, timeIn, timeOut)) WHERE `eID`= ? AND `proj_id` = ? AND `id` = (SELECT MAX(id))");
        $passval2 = array($id,$choice);
        $query2 ->execute($passval2);
        $query3 = $dbh -> query("SELECT hrWork as `hw` FROM projwork WHERE id=(SELECT MAX(id) FROM projwork) AND proj_id='$choice' AND eID='$id'");
        while($row = $query3->fetch()){
            $hw = $row['hw'];
            $query4 =  $dbh -> prepare("UPDATE project SET totalNumHours=(totalNumHours-(?)) WHERE projectID=?");
            $passval4 = array($hw,$choice);
            $query4 -> execute($passval4);
            $query9 =  $dbh -> prepare("UPDATE project SET totalNumHours = 0 WHERE totalNumHours < 0");
            $query9 -> execute();
        }
        $this->timelineTimeOut($id,$choice,$date,$time);

        echo "<script>window.location='projects.php?s=timeout';</script>";
        
        die();
      }catch(PDOException $ex){
        die();
      }
  }


function fetchprojm($id){
    try{
                global $dbh;
                $query = $dbh -> prepare('SELECT DISTINCT proj_id as `pid`, projectName as `pn`
                    FROM projwork pw JOIN project p ON p.projectID = pw.proj_id
                    WHERE eID = :id
                    AND timeOut IS NULL'); 
                $query -> bindParam(':id',$id);
                $query->execute();
                while($row = $query -> fetch() ) {
                    echo "<input type='hidden' name='option' value='".$row["pid"]."' readonly />";
                    echo "<input type='text' value='".$row["pn"]."' readonly />";
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

        function viewClass($id){
            global $dbh;

            $query = $dbh->query("SELECT se.skillID as 'sid', s.skillName as 'sn' FROM `employee` e 
                                    JOIN skillemp se ON e.employeeID=se.empID
                                    JOIN skills s ON s.skillID = se.skillID
                                    WHERE employeeID = '$id'");
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


function editProfileTimeline($id,$msg,$ctime,$date,$icon){
            global $dbh;
            try{
                $query = $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$msg,$ctime,$date,$icon);
                $query -> execute($passval);
            }catch (PDOException $e) {
    
            }
        }

function timelineTimeIn($id,$choice,$date1,$time){
        global $dbh;
        
        $icon = "fa fa-clock-o bg-green";

        $query = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `name`, projectName as `pn` 
            FROM employee e JOIN project p ON e.employeeID = p.draftsmanID WHERE employeeID='$id' AND projectID='$choice'");
       
        while($row = $query->fetch()){
                $name = $row['name'];
                
                $projectname = $row['pn'];
                $msg = $name." started working on <b>Project: ". $projectname. ".</b>";
                

                $query3= $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$msg,$time,$date1,$icon);
                $query3->execute($passval);
    }
}

function timelineTimeOut($id,$choice,$date,$time){
        global $dbh;
        $icon = "fa fa-clock-o bg-red";
      
      $query = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `name`, projectName as `pn` 
            FROM employee e JOIN project p ON e.employeeID = p.draftsmanID WHERE employeeID='$id' AND projectID='$choice'");
       
        while($row = $query->fetch()){
                $name = $row['name'];
                
                $projectname = $row['pn'];
                $msg = $name." stopped working on <b>Project: ". $projectname. ".</b>";
                

                $query3= $dbh->prepare("INSERT INTO timeline VALUES (?,?,?,?,?,?)");
                $passval = array(null,$id,$msg,$time,$date,$icon);
                $query3->execute($passval);

    }
}

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
                            <a href='".$row['link']."?nt=".$row['id']."'>
                            <i class='ion ion-ios7-people info'></i>".$row["fn"]."&nbsp;&nbsp; ".$row["msg"]."</a>
                            </li>";
                        }else{
                                echo "<script>alert('may mali')</script>";
                        }

            }
        }catch(PDOException $ex){

        }
}
};

$db = new MySQLDB;

?>