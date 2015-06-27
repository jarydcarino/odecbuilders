<?php 

	ob_start(); 
?>

<?php 
	include_once "../includes/database.php";
	$eid = $_GET['eid'];
	$type = $_GET['type'];

	$query2 = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `sname` FROM employee s WHERE s.employeeID='$eid' ");
    $row2 = $query2->fetch();

	$query = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `sname`, s.studentID as `sid`, skillName as `sn`, t.studID as `sid`, 
                        GROUP_CONCAT(DISTINCT '  ',sc.day, ' ') as `schedule`,
                        GROUP_CONCAT(DISTINCT '  ',sc.time, ' ') as `time`
                        FROM student s JOIN tutorial t ON s.studentID = t.studID
                        JOIN skills sk ON t.classID = sk.skillID
                        JOIN schedule sc ON sc.studID = s.studentID
                        WHERE t.status='$type' AND t.empID='$eid' ");
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
<h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;TUTOR REPORTS - ONGOING CLASSES</h1>
<?php echo '<h4 style="text-align:left;">Tutor: <b>'.$row2['sname'].'</b></h4>';?>
<table>
	<thead>
	    <tr>
	    	<th>Student ID</th>
	    	<th>Student Name</th>
	        <th>Class Name</th>
	        <th>Days</th>
	        <th>Time</th>
	    </tr>
	</thead>


	<tbody>
		<?php

			while($row = $query->fetch()){
		        echo '<tr>';
		        echo '<td>'.$row['sid'].'</td>';
		        echo '<td>'.$row['sname'].'</td>';
		        echo '<td>'.$row['sn'].'</td>';
		        echo '<td>'.$row['schedule'].'</td>';
		        echo '<td>'.$row['time'].'</td>';
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