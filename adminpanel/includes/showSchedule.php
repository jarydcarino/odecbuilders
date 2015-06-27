
<?php 
	include_once "database.php";
    global $dbh;
	echo $db -> ifLogin();
     $id = $_SESSION['empID']; 

	$q = intval($_GET['q']);


         echo          ' <h3 class="fs-title"><i class="fa fa-clock-o"></i> Schedule</h2>
                            <table class="table table-striped" style="text-align:center;">
                                <tr>
                                    <th style="text-align:center;">TIME</th>
                                    <th style="text-align:center;">Monday</th>
                                    <th style="text-align:center;">Tuesday</th>
                                    <th style="text-align:center;">Wednesday</th>
                                    <th style="text-align:center;">Thursday</th>
                                    <th style="text-align:center;">Friday</th>
                                    <th style="text-align:center;">Saturday</th>
                                </tr>';

         echo               "<tr>";
         echo               "<td>9:00 - 10:00 AM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '9:00 - 10:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>";

         echo               "<tr>";
         echo               "<td>10:00 - 11:00 AM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '10:00 - 11:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[7]" value="10:00 - 11:00 AM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>";

         echo               "<tr>";
         echo               "<td>11:00 - 12:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '11:00 - 12:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[13]" value="11:00 - 12:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[14]" value="11:00 - 12:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>"; 

         echo               "<tr>";
         echo               "<td>12:00 - 1:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '12:00 - 1:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[19]" value="12:00 - 1:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[20]" value="12:00 - 1:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[21]" value="12:00 - 1:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>"; 

         echo               "<tr>";
         echo               "<td>1:00 - 2:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '1:00 - 2:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[25]" value="1:00 - 2:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[26]" value="1:00 - 2:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[27]" value="1:00 - 2:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[28]" value="1:00 - 2:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Saturday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>";  

         echo               "<tr>";
         echo               "<td>2:00 - 3:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '2:00 - 3:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[31]" value="2:00 - 3:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[32]" value="2:00 - 3:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[33]" value="2:00 - 3:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[34]" value="2:00 - 3:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[35]" value="2:00 - 3:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>";

         echo               "<tr>";
         echo               "<td>3:00 - 4:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '3:00 - 4:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[37]" value="3:00 - 4:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[38]" value="3:00 - 4:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[39]" value="3:00 - 4:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[40]" value="3:00 - 4:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[41]" value="3:00 - 4:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[42]" value="3:00 - 4:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>"; 

         echo               "<tr>";
         echo               "<td>4:00 - 5:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '4:00 - 5:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[43]" value="4:00 - 5:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[44]" value="4:00 - 5:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[45]" value="4:00 - 5:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[46]" value="4:00 - 5:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[47]" value="4:00 - 5:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[48]" value="4:00 - 5:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>";

         echo               "<tr>";
         echo               "<td>5:00 - 6:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '5:00 - 6:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[49]" value="5:00 - 6:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[50]" value="5:00 - 6:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[51]" value="5:00 - 6:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[52]" value="5:00 - 6:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[53]" value="5:00 - 6:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[54]" value="5:00 - 6:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>"; 

         echo               "<tr>";
         echo               "<td>6:00 - 7:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '6:00 - 7:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[55]" value="6:00 - 7:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[56]" value="6:00 - 7:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[57]" value="6:00 - 7:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[58]" value="6:00 - 7:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[59]" value="6:00 - 7:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[60]" value="6:00 - 7:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>"; 

         echo               "<tr>";
         echo               "<td>7:00 - 8:00 PM</td>";
                            



                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$q'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        


                                            
                                              
                                                if($time == '7:00 - 8:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[61]" value="7:00 - 8:00 PM.Monday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[62]" value="7:00 - 8:00 PM.Tuesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[63]" value="7:00 - 8:00 PM.Wednesday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[64]" value="7:00 - 8:00 PM.Thursday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[65]" value="7:00 - 8:00 PM.Friday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1'){
                                                            if($status !=='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[66]" value="7:00 - 8:00 PM.Saturday.1"></input></td>';
                                                            }else{
                                                                echo '<td><input type="checkbox" disabled checked></input></td>';
                                                            }
                                                        }else{
                                                            echo '<td> </td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            
        echo                "</tr>";    
	
?>