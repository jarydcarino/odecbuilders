<?php 

	ob_start(); 

	        $pid = $_GET['pid'];
            $eid = $_GET['eid'];
            $type = $_GET['type'];
?>

<?php 
include_once "../includes/database.php";


	$query = $dbh->query("SELECT projectName as `pn`,CONCAT(firstName,' ',lastName) as `name`, totalNumHours as `th`,
                            startdate as `sdate`, duedate as `ddate`
                            FROM project p JOIN employee e ON p.draftsmanID=e.employeeID WHERE projectID='$pid'");


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
<h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;DAILY LOG</h1>

<?php
                        
    while($row = $query->fetch()){
        $s = date("F d, Y",strtotime($row['sdate']));
        $d = date("F d, Y",strtotime($row['ddate']));
        $hours = floor($row['th'] / 60);
        $minutes = ($row['th'] % 60);

        echo '<p style="text-align:left;"><b>Project Name: </b>'.$row['pn'].'</p>';
        echo '<p style="text-align:left;"><b>Draftsman: </b>'.$row['name'].'</p>';
        echo '<p style="text-align:left;"><b>Time Left: </b>'.$hours.' hrs and '.$minutes.' minutes</p>';
        echo '<p style="text-align:left;"><b>Start Date: </b>'.$s.'</p>';
        echo '<p style="text-align:left;"><b>Due Date: </b>'.$d.'</p>';
    }
?>

<table>
	<thead>
        <tr role="row">
            <th>Time In</th>
            <th>Time Out</th>
            <th>Minutes</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
    	<?php 
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
                    echo '<td>'.$ti.'</td>';
                    echo '<td>'.$to.'</td>';
                    echo '<td><b>'.$h.' hours and '.$m.' minutes</b></td>';
                    echo '<td>'.$d.'</td>';
                    echo '</tr>';
                    }

                }catch(PDOException $ex){
                    echo $ex->getMessage();
                }

            ?>
    </tbody>

    <tfoot>
        <?php
            $query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'");
            $row2 = $query2->fetch();

            $h = floor($row2['consumed'] / 60);
            $m = ($row2['consumed'] % 60);

            echo '<tr><td></td><td colspan = 2 style="text-align:right;">Total:</td>';
            echo '<td><b>'.$h.' hrs and '.$m.' minutes</b></td><td></td></tr>';
        ?> 
        
        
    </tfoot>
</table>
</page>

<?php 

		$content = ob_get_clean();
		require_once('html2pdf.class.php');
		$html2pdf = new HTML2PDF('L','Legal','fr');
	    $html2pdf->writeHTML($content);
	    $html2pdf->output('projlog.pdf');
?>