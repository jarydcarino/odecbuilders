<?php 
    include_once "../includes/database.php";
	echo $db -> ifLogin();
    $id = $_SESSION['empID'];
	ob_start(); ?>

<?php 
include_once "../includes/database.php";

$query = $dbh->query("SELECT * FROM
									(SELECT projectName as `pn`, projectID as `pid`,
									clientName as `client`, skillName as `sn`,
									CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
									location, totalNumHours as `due`,
									status, duedate, startdate, p.contactNum as `contact`
									FROM project p 
									JOIN employee e ON p.draftsmanID = e.employeeID
									JOIN skills s ON p.skillReq = s.skillID
									WHERE status = 'hold'
									AND e.employeeID = '$id') as `tablename`
									;
									");

$query -> setFetchMode(PDO::FETCH_ASSOC);
?>

<style>
	table {
	    border-collapse: collapse;
	}

	table, td, th {
	    border: 1px solid black;
	}

	th,td { 
	    padding: 10px;
	}
</style>

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm"> 
	<h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;Project Reports - On-hold Projects</h1>
	<table>
        
        <thead>
	        <tr>
	            <th>Project Title</th>
	            <th>Draftsman</th>
	            <th>Skill</th>
	            <th>Location</th>
	            <th>Due Date</th>
	            <th>Time Left</th>
	            <th>Time Consumed</th>
	            <th>Status</th>
	        </tr>
        </thead>
        
        <tbody>

<?php
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
					echo '<td>'.$row['pn'].'</td>';
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
						echo '<td>'.$status.'</td>';
					}else if($status == 'ongoing'){
						echo '<td>'.$status.'</td>';
					}else if($status == 'cancelled'){
						echo '<td><span style="color:red;">'.$status.'</span></td>';
					}else if($status == 'hold'){
						echo '<td>'.$status.'</td>';
					}

					echo'</tr>';
				}
?>
</tbody>
</table>
</page>

<?php 

		$content = ob_get_clean();
		require_once('html2pdf.class.php');
		$html2pdf = new HTML2PDF('L','Legal','fr');
	    $html2pdf->writeHTML($content);
	    $html2pdf->output('project_reports_ongoing.pdf');
?>