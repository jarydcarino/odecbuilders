<?php

     include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID'];
     $icon = '<i class="fa fa-dashboard"></i>';
     $title = "Overview";

?>
<!DOCTYPE html>
<html>
    <head>
        <?php 
            
            include_once "includes/head.php" ;
            
        ?>
    </head>
    <body class="skin-blue">
            <?php include_once "includes/navigation.php" ?>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <i class="fa fa-calendar"></i>
                                    <div class="box-title">Schedule</div>
                                     <div class="box-body" style="text-align:center;">
                                    <table class="table table-striped" style="text-align:center;">
                        <tr>
                            <th style="text-align:center;">TIME</th>
                            <th style="text-align:center;">Monday</th>
                            <th style="text-align:center;">Tuesday</th>
                            <th style="text-align:center;">Wednesday</th>
                            <th style="text-align:center;">Thursday</th>
                            <th style="text-align:center;">Friday</th>
                            <th style="text-align:center;">Saturday</th>
                            

                        </tr>
                    
                        <tr>
                            <td>9:00 - 10:00 AM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->query("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        //$query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '9:00 - 10:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                            
                        </tr>
                        <tr>
                            <td>10:00 - 11:00 AM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '10:00 - 11:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>11:00 - 12:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '11:00 - 12:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>12:00 - 1:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '12:00 - 1:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>1:00 - 2:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '1:00 - 2:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>2:00 - 3:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '2:00 - 3:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>3:00 - 4:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '3:00 - 4:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>4:00 - 5:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '4:00 - 5:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>5:00 - 6:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '5:00 - 6:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>6:00 - 7:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '6:00 - 7:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>7:00 - 8:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '7:00 - 8:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }
                                                    
                                                    
                                                }

                                                                     
                                        
                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        
                        

                    </table>
                                </div>
                                                                        
                                </div><!-- /.box-header -->
                                
                            </div><!-- /.box -->
                        </div>
                    </div>

                    <!-- top row -->
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
                            
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6 connectedSortable"> 
                            <!-- Box (with bar chart) -->
                                    <!-- tools box -->
                                         
                            

                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6 connectedSortable">
                            <!-- Map box -->
                            

                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
    </body>


</html>