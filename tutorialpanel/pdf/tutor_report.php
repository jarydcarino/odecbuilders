<?php 

	ob_start(); 
?>




<?php

include_once "../includes/database.php";

	$query = $dbh->query("SELECT DISTINCT CONCAT(firstName,' ',lastName) as `name`, picture, e.employeeID as `id`
					FROM employee e	JOIN account a ON e.employeeID = a.empID
					WHERE type = 'Tutorial' OR type = 'Draftsman/Tutor'"); ?> 

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
<h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;TUTOR REPORTS</h1>
<table>
	<thead>
		<tr>
			<th>Name</th>
		    <th>No. of Accomplished Classes</th>
		    <th>No. of Ongoing Classes</th>
		</tr>
    </thead>

    <tbody>
		<?php

		while($row = $query->fetch()){
			$id = $row['id'];
			
			$fin = $dbh->query("SELECT COUNT(*) as `fin` FROM tutorial t JOIN employee e ON t.empID = e.employeeID WHERE t.empID='$id' AND status='finished'");
			$countfin = $fin->fetch();

			$ongoing = $dbh->query("SELECT COUNT(*) as `ongoing` FROM tutorial t JOIN employee e ON t.empID = e.employeeID WHERE t.empID='$id' AND status='ongoing'");
			$countongoing = $ongoing->fetch();
			echo '<tr>';
			echo '<td>'.$row['name'].'</td>';
			
			if($countfin['fin']==0){
				echo '<td>'.$countfin['fin'].'</td>';
			}else{
				echo '<td>'.$countfin['fin'].'</td>';
			}

			if($countongoing['ongoing']==0){
				echo '<td>'.$countongoing['ongoing'].'</td>';
			}else{
				echo '<td>'.$countongoing['ongoing'].'</td>';
			}
			echo '</tr>';
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
	    $html2pdf->output('tutor_reports.pdf');
?>



