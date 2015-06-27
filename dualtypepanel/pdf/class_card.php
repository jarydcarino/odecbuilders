<?php 

	ob_start(); 
?>

<?php 
	include_once "../includes/database.php"; 
	$sid = $_GET['sid'];
	$class = $_GET['class'];
	$tutor = $_GET['tutor'];

	 $query = $dbh -> query("SELECT DISTINCT CONCAT(s.firstName, ' ', s.lastName) as `student`, skillName as `sn`, 
                    CONCAT(e.firstName, ' ', e.lastName) as `tutor`,
                    GROUP_CONCAT(DISTINCT '  ',sc.day, ' ') as `schedule`,
                    GROUP_CONCAT(DISTINCT '  ',sc.time, ' ') as `time`, t.status as `stat`
                    FROM student s 
                    JOIN tutorial t ON s.studentID = t.studID 
                    JOIN skills sk ON sk.skillID = t.classID
                    JOIN employee e ON e.employeeID = t.empID
                    JOIN schedule sc ON sc.studID = s.studentID
                    WHERE s.studentID = '$sid'");

	$query -> setFetchMode(PDO::FETCH_ASSOC);
	$row = $query->fetch();
	$stat = $row['stat'];
?>

<style>
	table {
	    border-collapse: collapse;
	}

	table, td, th {
	    border: 1px solid black;
	}

	th,td { 
	    padding: 5px;
	}
</style>

<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm"> 
	<h1><img src="../img/logo1.png" width="187">&nbsp;&nbsp;CLASS CARD</h1>
	<?php 
		
            echo '<p style="text-align:left;"><b>Class Name: </b>'.$class.'</p>';
            echo '<p style="text-align:left;"><b>Student Name: </b>'. $row['student'].'</p>';
            echo '<p style="text-align:left;"><b>Tutor: </b>'. $tutor.'</p>';
            
            if($stat == "ongoing"){
            	echo '<p style="text-align:left;"><b>Schedule: </b>'. $row['time']. ' - ' .$row['schedule'].'</p>';
        	}else{
        	}

        
	?>
	<table>
         
		  <col width="200">
		  <col width="200">
		  <col width="200">
        <thead>
	        <tr>
				<th>Date</th>
				<th>Instructor / Substitute</th>
				<th>Attendance</th>                          
	        </tr>
        </thead>
        
        <tbody>
        	<?php 
                                                
	            $eid = $_GET['eid'];
	            $sid = $_GET['sid'];


	            try{
	                $query = $dbh->query("SELECT c.date as `d`, CONCAT(e.firstName,' ', e.lastName) as `i`, 
	                    				attendance as `a`                   
	                                    FROM class c
	                                    JOIN employee e ON c.instID = e.employeeID
	                                    JOIN tutorial t ON c.tutorialID = t.tutorialID
	                                    JOIN student s ON t.studID = s.studentID
	                                    WHERE t.tutorialID = '$eid' AND s.studentID = '$sid'
	                                    ORDER BY c.date ");
	                $query -> setFetchMode(PDO::FETCH_ASSOC);
	                while($row = $query->fetch()){
	                   
	                    $attendance = $row['a'];
	                    $d = date("F d, Y",strtotime($row['d']));
	                    echo '<tr>';
	                    echo '<td>'.$d.'</td>';
	                    echo '<td>'.$row['i'].'</td>';
	                    if($attendance == 'Present'){
	                        echo '<td>'.$row['a'].'</td>';
	                    }else if($attendance == 'Absent'){
	                        echo '<td>'.$row['a'].'</td>';
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
		$html2pdf = new HTML2PDF('P','Letter','fr');
	    $html2pdf->writeHTML($content);
	    $html2pdf->output('class_card.pdf');
?>