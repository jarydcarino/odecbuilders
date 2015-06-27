<?php 

	ob_start(); 
?>

<?php 
	include_once "../includes/database.php";
	$eid = $_GET['eid'];

	$query2 = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `sname` FROM employee s WHERE s.employeeID='$eid' ");
    $row2 = $query2->fetch();

	$query = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `sname`, skillName as `sn`, t.studID as `sid` 
                        FROM student s JOIN tutorial t ON s.studentID = t.studID
                        JOIN skills sk ON t.classID = sk.skillID
                        WHERE t.status='finished' AND t.empID='$eid' ");
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
<?php echo '<h4 style="text-align:left;">Tutor: <b>'.$row2['sname'].'</b></h4>';?>
<table>
	<thead>
	    <tr>
	        <th>Class Name</th>
	        <th>Student Name</th>
	    </tr>
	</thead>


	<tbody>
		<?php

			while($row = $query->fetch()){
		        echo '<tr>';
		        echo '<td>'.$row['sn'].'</td>';
		        echo '<td>'.$row['sname'].'</td>';
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
	    $html2pdf->output('classes.pdf');
?>