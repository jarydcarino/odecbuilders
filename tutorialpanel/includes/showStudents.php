
<?php 
	include_once "database.php";
	echo $db -> ifLogin();
     $id = $_SESSION['empID']; 

	$q = intval($_GET['q']);

	date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d");

	try{



	$query = $dbh->query("SELECT studentID as `sid`, CONCAT(firstName, ' ', lastName) as `name`,
						skillName as `sn`, s.session as `sess`, tutorialID as `tid`,
						GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`,
						GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`
						FROM student s 
						JOIN skills sk ON s.classID = sk.skillID
						JOIN schedule ss ON s.studentID = ss.studID
						JOIN tutorial t ON t.studID = s.studentID
						WHERE s.classID='$q' AND ss.classsched=1 AND s.instID='$id' AND t.status='ongoing'
						GROUP BY ss.studID");
	
			echo "<table class='table table-bordered table-striped'>
				<thead>
				<tr>
				<th style='text-align:center;'>Student ID</th>
				<th style='text-align:center;'>Student Name</th>
				<th style='text-align:center;'>Time</th>
				<th style='text-align:center;'>Days</th>
				<th style='text-align:center;'>Remaining Sessions</th>
				<th style='text-align:center;'>Attendance</th>
				<th style='text-align:center;'>Classcard</th>
				<th style='text-align:center;'>Drop Class</th>
				</tr>
				</thead>";
	$count = $query->rowCount();
	if($count>0){
	while($row = $query->fetch()){
		
		$modalTitle = str_replace(' ', '', $row['sid']);
		$dropModal = str_replace(' ', '', 'd'.$row['sid']);
		$present = str_replace(' ', '', 'p'.$row['sid']);
		$absent = str_replace(' ', '', 'a'.$row['sid']);
		
		echo '<tbody>';
		echo "<tr style='text-align:center;'>";
		echo "<td>".$row['sid']."</td>";
		echo "<td>".$row['name']."</td>";
		echo "<td>".$row['time']."</td>";
		echo "<td>".$row['schedule']."</td>";
		echo "<td><span class='badge bg-green'>".$row['sess']."</span></td>";
			if($row['sess']==0){
				echo "<td style='text-align:center;'><a href=includes/finished.php?tid=".$row['tid']."><button class='btn btn-danger btn-sm' type='button'>FINISHED</button></a></td>";
			}else{
				echo "<td style='text-align:center;'><a href=#".$modalTitle."><button class='btn btn-success btn-sm' type='button'><i class='fa fa-pencil-square-o'></i> Mark Attendance</button></a></td>";
			}
		echo '<td style="text-align:center;"><a href="classcard2.php?tid='.$row['tid'].'&name='.$row['name'].'&class='.$row['sn'].'"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-fw fa-book"></i>&nbsp;View Classcard</button></a></td>';
		echo "<td><a href=#".$dropModal."><button class='btn btn-danger btn-sm' type='button'><i class='fa fa-times'></i> Drop Class</button></a></td>";
		echo "</tr>";
		echo "</tbody>";
		}
		echo '</table>';
	
	}elseif($count==0){
		echo '<tr>';
		echo '<td colspan="8" style="text-align:center;"><strong>NO DATA AVAILABLE FOR THIS CLASS</strong></td>';
		echo '</tr>';

	}


	$query = $dbh->query("SELECT studentID as `sid`, CONCAT(firstName, ' ', lastName) as `name`,
						skillName as `sn`, s.session as `sess`, tutorialID as `tid`,
						GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`,
						GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`
						FROM student s 
						JOIN skills sk ON s.classID = sk.skillID
						JOIN schedule ss ON s.studentID = ss.studID
						JOIN tutorial t ON t.studID = s.studentID
						WHERE s.classID='$q' AND ss.classsched=1 AND s.instID='$id' AND t.status='ongoing'
						GROUP BY ss.studID");
	
	while($row = $query->fetch()){
		$modalTitle = str_replace(' ', '', $row['sid']);
		$dropModal = str_replace(' ', '', 'd'.$row['sid']);
		$present = str_replace(' ', '', 'p'.$row['sid']);
		$absent = str_replace(' ', '', 'a'.$row['sid']);

		 echo '<div id="'.$modalTitle.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h2 style="text-align:center;">' .$row['name']. '</h2>
                				</div>

                				<div class="modal-body" style="text-align:center;">
					                <div>
					                	<p>'.$row['time'].'</p>
					                	<p>'.$row['schedule'].'</p>
					                	<p>'.$row['sn'].'</p>
					                	<p> Remaining Sessions: <span class="badge bg-green">'.$row['sess'].'</span></p>
	                				</div>
				                
				                </div>

				                <div class="modal-footer" style="text-align:center;">
				                	<a href="#'.$present.'"><button class="btn btn-success btn-sm" type="button">Present</button></a>
				                	<a href="#'.$absent.'"><button class="btn btn-danger btn-sm" type="button">Absent</button></a>
				                	<a href=#><button class="btn btn-sm" type="button">Close</button></a>
				                </div>
				            </div>
				        </div>';

	echo '<div id="'.$dropModal.'" class="modalDialog">
							<div class="modal-dialog">
								<div class="modal-header">
                					<h4 style="text-align:center;">DROP CLASS</h4>
                				</div>

                				<div class="modal-body" style="text-align:center;">
					                <div>
					                <p style="text-align:center;">Drop <b>' .$row['name']. '</b>?</p>
					                
	                				</div>
				                
				                </div>

				                <div class="modal-footer" style="text-align:center;">
				                	<a href="includes/dropclass.php?tid='.$row['tid'].'"><button class="btn btn-danger btn-sm" type="button">Yes</button></a>
				                    <a href=#><button class="btn btn-sm" type="button">No</button></a>
				                </div>
				            </div>
				        </div>';

	echo '<div id="'.$present.'" class="modalDialog">
			<div class="modal-dialog">
				<div class="modal-header">
                	<h4 style="text-align:center;">ATTENDANCE - ABSENT</h4>
                </div>

                <div class="modal-body" style="text-align:center;">
					
						<p style="text-align:center;"><b>' .$row['name']. '</b></p>
						<form method="POST" action="includes/present.php?tid='.$row['tid'].'">
						<b>DATE:</b><input type="date" name="attdate" max='.$date.' class="form-control" required/> 
							<br>
							<button type="submit" class="btn btn-success btn-sm">Submit</button>
						</form>
			            
				</div>

				<div class="modal-footer" style="text-align:center;">
				    <a href=#'.$modalTitle.'><button class="btn btn-sm" type="button">Back</button></a>
		        </div>
			</div>
		</div>';

		echo '<div id="'.$absent.'" class="modalDialog">
			<div class="modal-dialog">
				<div class="modal-header">
                	<h4 style="text-align:center;">ATTENDANCE - ABSENT</h4>
                </div>

                <div class="modal-body" style="text-align:center;">
					
						<p style="text-align:center;"><b>' .$row['name']. '</b></p>
						<form method="POST" action="includes/absent.php?tid='.$row['tid'].'">
						<b>DATE:</b><input type="date" name="attdate" max='.$date.' class="form-control" required/> 
							<br>
							<button type="submit" class="btn btn-success btn-sm">Submit</button>
						</form>
			            
				</div>

				<div class="modal-footer" style="text-align:center;">
				    <a href=#'.$modalTitle.'><button class="btn btn-sm" type="button">Back</button></a>
		        </div>
			</div>
		</div>';
	}

	

		

	}catch(PDOException $e){

	}
	
?>