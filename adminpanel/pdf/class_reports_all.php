<?php 

	ob_start(); ?>

<?php 
include_once "../includes/database.php";

	$query = $dbh->query("SELECT CONCAT(e.firstName,' ',e.lastName) as `tutor`, st.studentID as `sid`, CONCAT(st.firstName,' ',st.lastName) as `name`, 
						sk.skillName as `class`, st.instid as `inst`, t.status as `status`, st.session as `session` FROM tutorial t 
						JOIN employee e ON t.empID=e.employeeID 
						JOIN student st ON t.studID=st.studentID 
						JOIN skills sk ON t.classID = sk.skillID");
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
	<h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;CLASS REPORTS</h1>
	<table>
        
        <thead>
	        <tr>
	            <th>Class Name</th>
                <th>Student Name</th>
                <th>Tutor</th>
                <th>Sessions</th>
                <th>Status</th>
	        </tr>
        </thead>
        
        <tbody>
					<?php
					while($row = $query->fetch()){
		        			echo "<tr>";
							echo "<td>".$row['class']."</td>";
							echo "<td>".$row['name']."</td>";
							echo "<td>".$row['tutor']."</td>";
							echo "<td style='text-align:center;'>".$row['session']."</td>";

							if($row['status'] == 'ongoing'){
								echo "<td style='text-align:center;'>".$row['status']."</td>";
							}else if($row['status'] == 'dropped'){
								echo "<td style='text-align:center;'>".$row['status']."</td>";
							}else if($row['status'] == 'finished'){
								echo "<td style='text-align:center;'>".$row['status']."</td>";
							}
							echo "</tr>"; 
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
	    $html2pdf->output('class_reports.pdf');
?>