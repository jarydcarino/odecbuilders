
<?php 
	include_once "database.php";
    global $dbh;
	echo $db -> ifLogin();
     $id = $_SESSION['empID']; 
;
        $classID = intval($_GET['q']);
     echo           '<label style="float:left; display: block;"><i class="fa fa-user"></i> Select Tutor</label>';


                                    try{
                                        echo '<select class="form-control" name="tutor" required="required" onchange="showSchedule(this.value)">';
                                                                
                                        $query = $dbh->query("SELECT CONCAT (e.firstName, ' ', e.lastName) as `tutor`, e.employeeID as `empid`
                                                            FROM employee e 
                                                            JOIN account a ON e.employeeID = a.empID
                                                            JOIN skillemp se ON se.empID = a.empID
                                                            JOIN skills s ON s.skillID = se.skillID
                                                            WHERE a.type != 'Draftsman' AND se.skillID = '$classID'
                                                            GROUP BY `tutor`") ;
                                        $query -> setFetchMode(PDO::FETCH_ASSOC);
                                        echo '<option ></option>'; 

                                        $empID = $row['empid'];
                                        while($row = $query -> fetch()){
                                            echo "<option value=".$row['empid'].">".$row['tutor']."</option>";
                                        }

                                            echo "</select>";
                                        
                                        }catch(PDOException $ex){
                                            echo $ex->getMessage();
                                            die();
                                        }


echo'<br>';  

	
?>