<?php 

    ob_start(); 
    $eid = $_GET['eid'];
    include_once "../includes/database.php";
    
    $query = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `student`, 
                                                            sk.skillName as `sn`, sk.session as `sess`,s.studentID as `sid`,t.tutorialID as `tid`,
                                                            CONCAT(e.firstName, ' ', e.lastName) as `tutor`, status
                                                            FROM student s JOIN tutorial t ON s.studentID = t.studID
                                                            JOIN employee e ON e.employeeID =  t.empID
                                                            JOIN skills sk ON sk.skillID = t.classID WHERE s.instID = '$eid' AND status = 'finished';
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
    <h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;Tutor Report</h1>
    <table>
        
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Tutor</th>
                <th>Class</th>                           
                <th>Remaining Sessions</th>
                <th>Status</th>
            </tr>

        </thead>
    



        <tbody>


    <?php    while($row = $query->fetch()){
           
            $status = $row['status'];
            
            echo '<tr>';
            echo '<td>'.$row['student'].'</td>';
            echo '<td><i>'.$row['tutor'].'</i></td>';
            echo '<td>'.$row['sn'].'</td>';
            echo '<td style="text-align:center;">'.$row['sess'].'</td>';
            
            if($status == 'finished'){
                echo '<td>'.$status.'</td>';
            }else if($status == 'ongoing'){
                echo '<td>'.$status.'</td>';
            }else if($status == 'dropped'){
                echo '<td><span style="color:red;">'.$status.'</span></td>';
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