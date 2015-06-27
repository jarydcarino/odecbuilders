<!DOCTYPE html>
<?php
    //session_start();
?>
<html>
    <head>
        <?php 
            $title = "Assign Student";
            $icon = '<i class="fa fa-male"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
        ?>
    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php" ?>
                <!-- Main content -->
                <section class="content">
                    <form id="msform" method="POST">
                    <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active">Step 1</li>
                            <li style="margin-left:50%;">Step 2</li>
                        </ul>
                        <fieldset style="margin-bottom:50px;">
                            <h3 class="fs-title">Assign Student</h2>
                            <div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <strong>Success!</strong> The student was assigned to a tutor.
                            </div>
                            <label style="float:left;"><i class="fa fa-user"></i> Student Name</label><br>
                            <input name = "fname" id="firstName" type="text" placeholder="First Name" required/> <input name="lname" id="lastName" type="text" placeholder="Last Name" required/>
                        
                            <label for="email" style="float:left;"><i class="fa fa-envelope"></i> Email</label>
                            <input name="email" id="email" type="text" placeholder="eg. olol@gmail.com" required/>

                            <label for="contactNumber" style="float:left;"><i class="fa fa-mobile-phone"></i> Contact Number</label>
                            <input name="cnumber" id="contactNumber" type="text" placeholder="eg. 0915*******">
                            
                            <label style="float:left; display: block;"><i class="fa fa-book"></i> Class Name</label><br><br>
                            <div class="radio" style="text-align:left;">
                                <?php 
                                    $query = $dbh->query("SELECT skillName as `sk`, skillID as `sid`, session FROM skills WHERE skillType='class' AND stat='enabled'");
                                    while($row = $query->fetch()){
                                        echo "<input type='radio' name='classID' value='".$row['sid'].".".$row['session']."'>&nbsp;&nbsp;".$row['sk']."&nbsp; - &nbsp;".$row['session']." sessions<br>";
                                    }

                                ?>
                            </div>
                            <label style="float:left; display: block;"><i class="fa fa-user"></i> Select Tutor</label>
                                <?php
                                    global $dbh;
                                    try{
                                        echo '<select class="form-control" name="tutor">';
                                                                
                                        $query = $dbh->query("SELECT CONCAT (e.firstName, ' ', e.lastName) as `tutor`, e.employeeID as `empid`
                                                            FROM employee e 
                                                            JOIN account a ON e.employeeID = a.empID
                                                            JOIN skillemp se ON se.empID = a.empID
                                                            JOIN skills s ON s.skillID = se.skillID
                                                            WHERE a.type = 'Tutorial' OR a.type = 'Draftsman/Tutor'
                                                            GROUP BY `tutor`") ;
                                        $query -> setFetchMode(PDO::FETCH_ASSOC);
                                        echo '<option ></option>'; 

                                        
                                        while($row = $query -> fetch()){
                                            echo "<option value=".$row['empid'].">".$row['tutor']."</option>";
                                        }

                                            echo "</select>";
                                            $empID = $row['empid'];
                                        }catch(PDOException $ex){
                                            echo $ex->getMessage();
                                            die();
                                        }
                                ?><br>
                            <input type="button" name="next" class="next action-button" value="Next" />  
                        </fieldset>

                <fieldset style="margin-bottom:50px;">
                    <h3 class="fs-title"><i class="fa fa-clock-o"></i> Schedule</h2>
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
                                            
                                            <td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1"></input></td>                                            
                                            <td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1"></input ></td>
                                            
                                        </tr>
                                        <tr>
                                            <td>10:00 - 11:00 AM</td>
                                            <td><input type="checkbox" name="availabletime[7]" value="10:00 - 11:00 AM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Saturday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>11:00 - 12:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[13]" value="11:00 - 12:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[14]" value="11:00 - 12:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Saturday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>12:00 - 1:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[19]" value="12:00 - 1:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[20]" value="12:00 - 1:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[21]" value="12:00 - 1:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Saturday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>1:00 - 2:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[25]" value="1:00 - 2:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[26]" value="1:00 - 2:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[27]" value="1:00 - 2:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[28]" value="1:00 - 2:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Saturday.1"></input></td>

                                        </tr>
                                        <tr>
                                            <td>2:00 - 3:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[31]" value="2:00 - 3:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[32]" value="2:00 - 3:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[33]" value="2:00 - 3:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[34]" value="2:00 - 3:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[35]" value="2:00 - 3:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Saturday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>3:00 - 4:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[37]" value="3:00 - 4:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[38]" value="3:00 - 4:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[39]" value="3:00 - 4:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[40]" value="3:00 - 4:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[41]" value="3:00 - 4:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[42]" value="3:00 - 4:00 PM.Saturday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>4:00 - 5:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[43]" value="4:00 - 5:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[44]" value="4:00 - 5:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[45]" value="4:00 - 5:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[46]" value="4:00 - 5:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[47]" value="4:00 - 5:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[48]" value="4:00 - 5:00 PM.Saturday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>5:00 - 6:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[49]" value="5:00 - 6:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[50]" value="5:00 - 6:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[51]" value="5:00 - 6:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[52]" value="5:00 - 6:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[53]" value="5:00 - 6:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[54]" value="5:00 - 6:00 PM.Saturday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>6:00 - 7:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[55]" value="6:00 - 7:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[56]" value="6:00 - 7:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[57]" value="6:00 - 7:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[58]" value="6:00 - 7:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[59]" value="6:00 - 7:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[60]" value="6:00 - 7:00 PM.Saturday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>7:00 - 8:00 PM</td>
                                            <td><input type="checkbox" name="availabletime[61]" value="7:00 - 8:00 PM.Monday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[62]" value="7:00 - 8:00 PM.Tuesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[63]" value="7:00 - 8:00 PM.Wednesday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[64]" value="7:00 - 8:00 PM.Thursday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[65]" value="7:00 - 8:00 PM.Friday.1"></input></td>
                                            <td><input type="checkbox" name="availabletime[66]" value="7:00 - 8:00 PM.Saturday.1"></input></td>
                                        </tr>
                                    </table>
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="submit" name="add" value="Assign" class="submit action-button"/> 
                </fieldset>

                        
                    </form>
                </section><!-- /.content -->

<?php
    global $dbh;
    try{

        if(isset($_POST['add'])){

            $schedule = $_REQUEST['availabletime'];

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $cnumber = $_POST['cnumber'];
            // $classID = $_POST['classID'];
            $tutor = $_POST['tutor'];
            //echo $tutor;

            $session = explode(".", $_POST['classID']);
            $classID = $session[0];
            $numSession = $session[1];

            echo $db -> assignStudents($fname,$lname,$email,$cnumber,$numSession,$classID,$tutor,$id);            
            
            foreach ($schedule as $sched){
                list($time,$day,$status) = explode(".", $sched);
                echo $db -> insertStudentSched($tutor,$classID,$day,$time,$status);            
            }
        }
    } catch (PDOException $e) {
    }
?>
</body>
</html>