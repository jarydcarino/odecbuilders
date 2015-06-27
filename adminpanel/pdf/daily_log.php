<?php 

	ob_start(); 

	        $did = $_GET['did'];

?>

<?php 
include_once "../includes/database.php";
//$pid = $_GET['pid'];


$query = $dbh->query("SELECT CONCAT(firstName,' ',lastName) as `name`
                            FROM employee WHERE employeeID='$did'");
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
        echo '<p style="text-align:left;"><b>Draftsman: </b>'.$row['name'].'</p>';
    }
?>
<table>
	<thead>
        <tr role="row">
            <th>Project Title</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Minutes</th>
        </tr>
    </thead>

    <tbody>
    	<?php 
            try{
                $query = $dbh->query("SELECT p.proj_ID as `pid`, pr.projectName as `name`,
                                    p.timeIn as `timein`, p.timeOUt as `timeout`, p.date as `date`,
                                    hrWork as `work`
                                    FROM projwork p
                                    JOIN project pr
                                    WHERE p.proj_ID = pr.projectID
                                    AND p.eID='$did';
                                    ");
                $query -> setFetchMode(PDO::FETCH_ASSOC);
                while($row = $query->fetch()){
                    $h = floor($row['work'] / 60);
                    $m = ($row['work'] % 60);
                    $ti = date("h:i A",strtotime($row['timein']));
                    $to = date("h:i A",strtotime($row['timeout']));
                    echo '<tr>';
                    echo '<td>'.$row['name'].'</td>';
                    echo '<td>'.$ti.'</td>';
                    echo '<td>'.$to.'</td>';
                    echo '<td><b>'.$h.' hrs and '.$m.' minutes</b></td>';
                    echo '</tr>';
                }

            }catch(PDOException $ex){
                echo $ex->getMessage();
            }

            ?>
    </tbody>

    <tfoot>
        <?php
            $query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE eID='$did'
");
            $row2 = $query2->fetch();

            $h = floor($row2['consumed'] / 60);
            $m = ($row2['consumed'] % 60);

            echo '<tr>
                    <td></td>';
            echo '<td></td>';
            echo '<td>Total:</td>';
            echo '<td>'.$h.' hrs and '.$m.' minutes</td>
            </tr>';
        ?> 
        
        
    </tfoot>
</table>
</page>

<?php 
		$content = ob_get_clean();
		require_once('html2pdf.class.php');
		$html2pdf = new HTML2PDF('L','Legal','fr');
	    $html2pdf->writeHTML($content);
	    $html2pdf->output('dailylog.pdf');
?>