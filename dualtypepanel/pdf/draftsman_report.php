<?php 

	ob_start(); 
?>

<?php 
include_once "../includes/database.php";

try{
	$query = $dbh->query("SELECT DISTINCT(CONCAT(firstname,' ', lastname)) as `name`, picture, empID as `id` FROM 
						project left join account on project.draftsmanID = account.empID left join
						employee on account.empID = employee.employeeID where account.type = 'Draftsman/Tutor'
						or account.type = 'Draftsman';
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
<h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;DRAFTSMAN REPORTS</h1>
<table>
        <thead>
            <tr>
                <th>Name</th>
                <th>No. of Accomplished Projects</th>
                <th>No. of Ongoing Projects</th>
            </tr>
        </thead>
        <tbody>



<?php	
	while($row = $query->fetch()){
		$query_finished = $dbh->query("SELECT count(*) as `finished` FROM project where  `status` = 'finished' and draftsmanID = '" .$row['id'] ."';");
		$query_ongoing = $dbh->query("SELECT count(*) as `ongoing` FROM project where  `status` = 'ongoing' and draftsmanID = '". $row['id'] ."';");
		$stat_finished = $query_finished->fetch();
		$stat_ongoing = $query_ongoing->fetch();
							

		echo '<tr>'; 
		echo '<td>'.$row['name'].'</td>';
		
		if($stat_finished['finished']==0){
		echo '<td>'.$stat_finished['finished'].'</td>';
		}else{
			echo '<td>'.$stat_finished['finished'].'</td>';
		}

		if($stat_ongoing['ongoing']==0){
			echo '<td>'.$stat_ongoing['ongoing'].'</td>';
		}else{
			echo '<td>'.$stat_ongoing['ongoing'].'</td>';
		}
		echo '</tr>';

	}

}catch(PDOException $ex){
	echo $ex->getMessage();
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
	    $html2pdf->output('draftsman_reports.pdf');
?>