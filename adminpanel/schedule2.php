
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Schedule";
            $icon = '<i class="fa fa-calendar"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
            $tid = $_GET['id'];
                        

        ?>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php include_once "includes/navigation.php" ?>

                <!-- Main content -->
        <section class="content">
            <form id="msform" method="POST" style="width:80%; ">
            <!-- progressbar -->
                
                <!-- fieldsets -->

                <fieldset style="margin-bottom:50px;">
                    
                    <h2 class="fs-title">Available Schedule</h2>
                    <?php 
                        $query = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `name` FROM employee WHERE employeeID='$tid'; ");
                        while($row=$query->fetch()){
                            echo '<p style="float:left;">NAME: <b>'.$row['name'].'</b></p>';
                        }
                    ?>

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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '9:00 - 10:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$tid'");
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
                                            WHERE s.employeeID = '$tid' AND s.studID = '$studID'");
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
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
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
                    <a href="listOfTutors.php"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>
                </fieldset> 



            </form>
        </section><!-- /.content -->
    </body>
</html>



