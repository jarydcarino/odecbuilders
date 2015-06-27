<!DOCTYPE html>

<html>
    <head>
        <?php 
            $title = "Edit Class Schedule";
            $icon = '<i class="fa fa-male"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
        ?>
    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php";

            $empid = $_GET['eid'];
            $sid = $_GET['sid'];
            $n = $_GET['n'];
            $c = $_GET['c'];

            $null = null;
            global $dbh;

            try{
            $query = $dbh->query("SELECT CONCAT(firstName,' ',lastName) as `name` FROM employee WHERE employeeID = '$empid'");
            while($row = $query->fetch()){
                $tutor = $row['name'];

                $query2 = $dbh->query("SELECT firstName as `fn`,lastName as `ln` FROM student WHERE studentID = '$sid'");
                $row2 = $query2->fetch();

                $first=$row2['fn'];
                $last = $row2['ln'];


        ?>
                <!-- Main content -->
                <section class="content">

                    <form id="msform" method="POST"  enctype="multipart/form-data" onsubmit="return validate_sched();">
                    <!-- progressbar -->
                      
                <fieldset style="margin-bottom:50px;">
                   
                    <h2 class="fs-title">Available Schedule</h2>
                    <?php
                       

                        }

                                
                            ?>

                    <label for="name" style="float: left;"><i class="fa fa-user"></i>&nbsp;First Name</label><input type="text" name="first" value="<?php echo $first ?>" id="first" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
                    <label for="name" style="float: left;"><i class="fa fa-user"></i>&nbsp;Last Name</label><input type="text" name="last" value="<?php echo $last ?>" id="last" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
                    <label for="tutor" style="float: left;"><i class="fa fa-user"></i>&nbsp;Tutor: <b><?php  echo $tutor ?></b></label>


                    

                    <table class="table table-striped" style="text-align:center;" id="sched">


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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '9:00 - 10:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                             echo '<input type="hidden" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '10:00 - 11:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[7]" value="10:00 - 11:00 AM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[7]" value="10:00 - 11:00 AM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[7]" value="10:00 - 11:00 AM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[7]" value="10:00 - 11:00 AM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[7]" value="10:00 - 11:00 AM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[8]" value="10:00 - 11:00 AM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[8]" value="10:00 - 11:00 AM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[9]" value="10:00 - 11:00 AM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[9]" value="10:00 - 11:00 AM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[10]" value="10:00 - 11:00 AM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[10]" value="10:00 - 11:00 AM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[11]" value="10:00 - 11:00 AM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[11]" value="10:00 - 11:00 AM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[12]" value="10:00 - 11:00 AM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[12]" value="10:00 - 11:00 AM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '11:00 - 12:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[13]" value="11:00 - 12:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[13]" value="11:00 - 12:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[13]" value="11:00 - 12:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[13]" value="11:00 - 12:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[13]" value="11:00 - 12:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[14]" value="11:00 - 12:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[14]" value="11:00 - 12:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[14]" value="11:00 - 12:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[14]" value="11:00 - 12:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[14]" value="11:00 - 12:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[15]" value="11:00 - 12:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[15]" value="11:00 - 12:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[16]" value="11:00 - 12:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[16]" value="11:00 - 12:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[17]" value="11:00 - 12:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[17]" value="11:00 - 12:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[18]" value="11:00 - 12:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[18]" value="11:00 - 12:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '12:00 - 1:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[19]" value="12:00 - 1:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[19]" value="12:00 - 1:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[19]" value="12:00 - 1:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[19]" value="12:00 - 1:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[19]" value="12:00 - 1:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[20]" value="12:00 - 1:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[20]" value="12:00 - 1:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[20]" value="12:00 - 1:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[20]" value="12:00 - 1:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[20]" value="12:00 - 1:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[21]" value="12:00 - 1:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[21]" value="12:00 - 1:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[21]" value="12:00 - 1:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[21]" value="12:00 - 1:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[21]" value="12:00 - 1:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[22]" value="12:00 - 1:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[22]" value="12:00 - 1:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[23]" value="12:00 - 1:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[23]" value="12:00 - 1:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[24]" value="12:00 - 1:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[24]" value="12:00 - 1:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '1:00 - 2:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[25]" value="1:00 - 2:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[25]" value="1:00 - 2:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[25]" value="1:00 - 2:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[25]" value="1:00 - 2:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[25]" value="1:00 - 2:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[26]" value="1:00 - 2:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[26]" value="1:00 - 2:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[26]" value="1:00 - 2:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[26]" value="1:00 - 2:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[26]" value="1:00 - 2:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[27]" value="1:00 - 2:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[27]" value="1:00 - 2:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[27]" value="1:00 - 2:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[27]" value="1:00 - 2:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[27]" value="1:00 - 2:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[28]" value="1:00 - 2:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[28]" value="1:00 - 2:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[28]" value="1:00 - 2:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[28]" value="1:00 - 2:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[28]" value="1:00 - 2:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[29]" value="1:00 - 2:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[29]" value="1:00 - 2:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[30]" value="1:00 - 2:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[30]" value="1:00 - 2:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '2:00 - 3:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[31]" value="2:00 - 3:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[31]" value="2:00 - 3:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[31]" value="2:00 - 3:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[31]" value="2:00 - 3:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[31]" value="2:00 - 3:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[32]" value="2:00 - 3:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[32]" value="2:00 - 3:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[32]" value="2:00 - 3:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[32]" value="2:00 - 3:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[32]" value="2:00 - 3:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[33]" value="2:00 - 3:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[33]" value="2:00 - 3:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[33]" value="2:00 - 3:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[33]" value="2:00 - 3:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[33]" value="2:00 - 3:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[34]" value="2:00 - 3:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[34]" value="2:00 - 3:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[34]" value="2:00 - 3:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[34]" value="2:00 - 3:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[34]" value="2:00 - 3:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[35]" value="2:00 - 3:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[35]" value="2:00 - 3:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[35]" value="2:00 - 3:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[35]" value="2:00 - 3:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[35]" value="2:00 - 3:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[36]" value="2:00 - 3:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[36]" value="2:00 - 3:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '3:00 - 4:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[37]" value="3:00 - 4:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[37]" value="3:00 - 4:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[37]" value="3:00 - 4:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[37]" value="3:00 - 4:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[37]" value="3:00 - 4:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[38]" value="3:00 - 4:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[38]" value="3:00 - 4:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[38]" value="3:00 - 4:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[38]" value="3:00 - 4:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[38]" value="3:00 - 4:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[39]" value="3:00 - 4:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[39]" value="3:00 - 4:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[39]" value="3:00 - 4:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[39]" value="3:00 - 4:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[39]" value="3:00 - 4:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[40]" value="3:00 - 4:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[40]" value="3:00 - 4:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[40]" value="3:00 - 4:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[40]" value="3:00 - 4:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[40]" value="3:00 - 4:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[41]" value="3:00 - 4:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[41]" value="3:00 - 4:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[41]" value="3:00 - 4:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[41]" value="3:00 - 4:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[41]" value="3:00 - 4:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[42]" value="3:00 - 4:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[42]" value="3:00 - 4:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[42]" value="3:00 - 4:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[42]" value="3:00 - 4:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[42]" value="3:00 - 4:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '4:00 - 5:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[43]" value="4:00 - 5:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[43]" value="4:00 - 5:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[43]" value="4:00 - 5:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[43]" value="4:00 - 5:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[43]" value="4:00 - 5:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[44]" value="4:00 - 5:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[44]" value="4:00 - 5:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[44]" value="4:00 - 5:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[44]" value="4:00 - 5:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[44]" value="4:00 - 5:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[45]" value="4:00 - 5:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[45]" value="4:00 - 5:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[45]" value="4:00 - 5:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[45]" value="4:00 - 5:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[45]" value="4:00 - 5:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[46]" value="4:00 - 5:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[46]" value="4:00 - 5:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[46]" value="4:00 - 5:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[46]" value="4:00 - 5:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[46]" value="4:00 - 5:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[47]" value="4:00 - 5:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[47]" value="4:00 - 5:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[47]" value="4:00 - 5:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[47]" value="4:00 - 5:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[47]" value="4:00 - 5:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[48]" value="4:00 - 5:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[48]" value="4:00 - 5:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[48]" value="4:00 - 5:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[48]" value="4:00 - 5:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[48]" value="4:00 - 5:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '5:00 - 6:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[49]" value="5:00 - 6:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[49]" value="5:00 - 6:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[49]" value="5:00 - 6:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[49]" value="5:00 - 6:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[49]" value="5:00 - 6:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[50]" value="5:00 - 6:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[50]" value="5:00 - 6:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[50]" value="5:00 - 6:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[50]" value="5:00 - 6:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[50]" value="5:00 - 6:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[51]" value="5:00 - 6:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[51]" value="5:00 - 6:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[51]" value="5:00 - 6:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[51]" value="5:00 - 6:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[51]" value="5:00 - 6:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[52]" value="5:00 - 6:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[52]" value="5:00 - 6:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[52]" value="5:00 - 6:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[52]" value="5:00 - 6:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[52]" value="5:00 - 6:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[53]" value="5:00 - 6:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[53]" value="5:00 - 6:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[53]" value="5:00 - 6:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[53]" value="5:00 - 6:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[53]" value="5:00 - 6:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[54]" value="5:00 - 6:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[54]" value="5:00 - 6:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[54]" value="5:00 - 6:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[54]" value="5:00 - 6:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[54]" value="5:00 - 6:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '6:00 - 7:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[55]" value="6:00 - 7:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[55]" value="6:00 - 7:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[55]" value="6:00 - 7:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[55]" value="6:00 - 7:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[55]" value="6:00 - 7:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[56]" value="6:00 - 7:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[56]" value="6:00 - 7:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[56]" value="6:00 - 7:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[56]" value="6:00 - 7:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[56]" value="6:00 - 7:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[57]" value="6:00 - 7:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[57]" value="6:00 - 7:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[57]" value="6:00 - 7:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[57]" value="6:00 - 7:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[57]" value="6:00 - 7:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[58]" value="6:00 - 7:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[58]" value="6:00 - 7:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[58]" value="6:00 - 7:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[58]" value="6:00 - 7:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[58]" value="6:00 - 7:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[59]" value="6:00 - 7:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[59]" value="6:00 - 7:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[59]" value="6:00 - 7:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[59]" value="6:00 - 7:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[59]" value="6:00 - 7:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[60]" value="6:00 - 7:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[60]" value="6:00 - 7:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[60]" value="6:00 - 7:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[60]" value="6:00 - 7:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[60]" value="6:00 - 7:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
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
                                            WHERE s.employeeID = '$empid' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '7:00 - 8:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[61]" value="7:00 - 8:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[61]" value="7:00 - 8:00 PM.Monday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[61]" value="7:00 - 8:00 PM.Monday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[61]" value="7:00 - 8:00 PM.Monday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[61]" value="7:00 - 8:00 PM.Monday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[62]" value="7:00 - 8:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[62]" value="7:00 - 8:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[62]" value="7:00 - 8:00 PM.Tuesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[62]" value="7:00 - 8:00 PM.Tuesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[62]" value="7:00 - 8:00 PM.Tuesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[63]" value="7:00 - 8:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[63]" value="7:00 - 8:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[63]" value="7:00 - 8:00 PM.Wednesday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[63]" value="7:00 - 8:00 PM.Wednesday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[63]" value="7:00 - 8:00 PM.Wednesday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[64]" value="7:00 - 8:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[64]" value="7:00 - 8:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[64]" value="7:00 - 8:00 PM.Thursday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[64]" value="7:00 - 8:00 PM.Thursday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[64]" value="7:00 - 8:00 PM.Thursday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[65]" value="7:00 - 8:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[65]" value="7:00 - 8:00 PM.Friday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[65]" value="7:00 - 8:00 PM.Friday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[65]" value="7:00 - 8:00 PM.Friday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[65]" value="7:00 - 8:00 PM.Friday.1.'.$sid.'.'.$c.'"></input></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1' && $student == $n){
                                                            echo '<input type="hidden" name="availabletime[66]" value="7:00 - 8:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[66]" value="7:00 - 8:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked></input></td>';
                                                        }else if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><input type="checkbox" name="availabletime[66]" value="7:00 - 8:00 PM.Saturday.1.'.$sid.'.'.$c.'" checked disabled></input></td>';
                                                        }else if($av == '1'){
                                                            echo '<input type="hidden" name="availabletime[66]" value="7:00 - 8:00 PM.Saturday.'.$null.'.'.$null.'.'.$null.'"></input>
                                                            <td><input type="checkbox" name="availabletime[66]" value="7:00 - 8:00 PM.Saturday.1.'.$sid.'.'.$c.'"></input></td>';
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
                    <a href="listOfClasses.php"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>
                    <button type="submit" style="width:25%;" name="save" class="btn btn-primary"/>Save</button>
                </fieldset> 

                

                        
                    </form>
                </section><!-- /.content -->

</body>
</html>

<?php
            
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
                
            } 

        if(isset($_POST['save'])){
            $pangalan = $_POST['first'];
            $pangals = $_POST['last'];
            $schedule = $_REQUEST['availabletime'];
            $sid = $_GET['sid'];

        echo $db -> editProfile2($pangalan,$pangals,$sid);

            foreach ($schedule as $sched){
                    list($time,$day,$status,$stud,$class) = explode(".", $sched);
                    echo $db -> editStudentSched($status,$stud,$class,$day,$empid,$time);          
            }
        }

?>