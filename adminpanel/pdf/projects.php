<?php 

	ob_start(); 
?>

<?php 
include_once "../includes/database.php";
$id = $_GET['id'];
$stat = $_GET['stat'];
	$query = $dbh->query("SELECT projectName as `pn`, projectID as `pid`,
									skillName as `sn`,
									status, clientName as `cn`
									FROM project p 
									LEFT JOIN skills s ON p.skillReq = s.skillID
									WHERE status='$stat' AND draftsmanID = $id;
									");
	$query1 = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `name` FROM employee WHERE employeeID=$id");

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
<?php 
	while($row1 = $query1->fetch()){
		echo '<h3>'.$row1['name'].'</h3>';
	}
?>
<table>
        <thead>
            <tr>
                <th>Project Title</th>
                <th>Owner</th>
                <th>Skill</th>
            </tr>
        </thead>
        <tbody>
        	<?php
        	while($row = $query->fetch()){

					echo '<tr>';
					echo '<td>'.$row['pn'].'</td>';
					echo '<td>'.$row['cn'].'</td>';
					echo '<td>'.$row['sn'].'</td>';
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
	    $html2pdf->output('accomplished.pdf');
?>