<?php 

	ob_start(); 
	$eid = $_GET['eid'];
	include_once "../includes/database.php";
    
    $query = $dbh->query("SELECT * FROM
                        (SELECT projectName as `pn`, projectID as `pid`,
                        clientName as `client`, skillName as `sn`,
                        CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
                        location,
                        status, duedate
                        FROM project p 
                        JOIN employee e ON p.draftsmanID = e.employeeID
                        JOIN skills s ON p.skillReq = s.skillID
                        WHERE e.employeeID='$eid' AND status = 'finished') as `tablename`
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
	<h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;Draftsman Report</h1>
	<table>
        
        <thead>
	        <tr>
	            <th>Project Title</th>
                <th>Draftsman</th>
                <th>Skill</th>                           
                <th>Due Date</th>
                <th>Owner</th>
                <th>Status</th>
            </tr>

        </thead>
    



        <tbody>


    <?php    while($row = $query->fetch()){
           
            $status = $row['status'];

            $d = date("F d, Y",strtotime($row['duedate']));
            
            echo '<tr>';
            echo '<td>'.$row['pn'].'</td>';
            echo '<td><i>'.$row['draftsman'].'</i></td>';
            echo '<td>'.$row['sn'].'</td>';
            echo '<td>'.$d.'</td>';
            echo '<td>'.$row['client'].'</td>';
            
            if($status == 'finished'){
                echo '<td>'.$status.'</td>';
            }else if($status == 'ongoing'){
                echo '<td>'.$status.'</td>';
            }else if($status == 'cancelled'){
                echo '<td><span style="color:red;">'.$status.'</span></td>';
            }else if($status == 'hold'){
                echo '<td>'.$status.'</td>';
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
	    $html2pdf->output('draftsman_individual_reports.pdf');
?>