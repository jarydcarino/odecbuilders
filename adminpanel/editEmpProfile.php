<?php 
    include_once "includes/database.php";
    echo $db -> ifLogin();
            $id = $_SESSION['empID'];

?>



<!DOCTYPE html>
<html>
    <head>
        <?php 
            $icon = '<i class="fa fa-user"></i>';
            $title = "Edit Profile";
            include_once "includes/head.php";
            $GLOBALS['empid'] = $_GET['id'];

            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d");

            global $dbh;

            try {
                $query = $dbh -> prepare("SELECT firstName as `f`, lastName as `l`, contactNum as `c`, email as `e`, address as `a`, bday as `b`, picture as  `p` FROM employee WHERE employeeID = :empid");
                $query -> bindParam(":empid", $empid);
                $query -> execute();

                $query ->setFetchMode(PDO::FETCH_ASSOC);

                while($row = $query->fetch()){
                    $fname = $row['f'];
                    $lname = $row['l'];
                    $contact = $row['c'];
                    $add = $row['a'];
                    $eadd = $row['e'];
                    $pic = $row['p'];
                    $birth = $row['b'];
                }

                $query = $dbh -> prepare("SELECT skillID as `si` FROM skillemp WHERE empID = :empid");
                $query -> bindParam(":empid", $empid);
                $query -> execute();

                $query ->setFetchMode(PDO::FETCH_ASSOC);

                while($row = $query->fetch()){
                    $skill[] = $row['si'];
                }

                $query = $dbh -> prepare("SELECT skillID as `si`, skillName as `sn` FROM skills");
                $query -> bindParam(":empid", $empid);
                $query -> execute();

                $query ->setFetchMode(PDO::FETCH_ASSOC);

                while($row = $query->fetch()){
                    $sid[] = $row['si'];
                    $sn[] = $row['sn'];
                }

                $query = $dbh -> prepare("SELECT * FROM account WHERE empID = :empid");
                $query -> bindParam(":empid", $empid);
                $query -> execute();

                $query ->setFetchMode(PDO::FETCH_ASSOC);

                while($row = $query->fetch()){
                    $user = $row['username'];
                    $password = $row['password'];
                    $type = $row['type'];
                



        ?>


    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php"; ?>

                <!-- Main content -->
                <section class="content">

            


            <form name="form" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <?php
                                if(isset($_GET['s'])){
                                    echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <strong>Success!</strong> Employee profile has been updated. <a href="viewProfile.php?id='.$GLOBALS['empid'].'">View Profile.</a> or go back to 
                                        <a href="listOfEmployees.php">List of Employees.</a>
                                    </div>';

                                }
                                
                    ?>
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <span class="glyphicon glyphicon-user"></span>
                                <h3 class="box-title">&nbsp;Personal Details</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                    <div class="form-inline">
                                      <div class="form-group" style="width: 50%;">
                                        <label for="firstName">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="fname" value="<?php echo $fname ?>" maxlength="25" pattern="[A-Za-z].{0,}" required>
                                      </div>
                                      <div class="form-group" style="width: 49%;">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lname" value="<?php echo $lname ?>" maxlength="25" pattern="[A-Za-z].{0,}" required>
                                      </div>
                                    </div>
                                  <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $add ?>" maxlength="100" pattern="[A-Za-z].{0,}" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="contact">Contact Number</label>
                                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact ?>" maxlength="11" pattern="[^a-zA-Z][0-9]{6,}" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $eadd ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="birthdate"><i class="fa fa-calendar"></i> Birth date</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $birth ?>" max="<?php echo $date ?>" required>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <span class="fa fa-edit"></span>
                                <h3 class="box-title">&nbsp;Additional Information</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                    <input type="hidden" name="pic" value="<?php echo $pic ?>" />
                                    <i class="fa fa-camera"></i><b> Profile Picture</b></label>
                                    <input data-label="Upload" class="demo" value="<?php echo $pic ?>" type="file" name="picture" id="picture" />
                                    <i class="fa fa-user"></i><b> Employee Type</b></label>
                                                <div class="radio">
                                                    <input type="radio"  name="type" value="Draftsman" required <?php echo ($type== 'Draftsman') ?  "checked" : "" ;  ?> />
                                                    Draftsman &nbsp;&nbsp;
                                                    <input type="radio" name="type" value="Tutorial" required <?php echo ($type== 'Tutorial') ?  "checked" : "" ;  ?> />
                                                    Tutor &nbsp;&nbsp;
                                                    <input type="radio" name="type" value="Draftsman/Tutor" required <?php echo ($type== 'Draftsman/Tutor') ?  "checked" : "" ;  ?> />
                                                    Draftsman/Tutor
                                                </div>
                                            <i class="fa fa-pencil"></i><b> Skills</b></label><br>
                                                                        
                                                    <select id="select" multiple="multiple" name="skill[]" required>
                                                        <?php
                                                            while(list($k,$v)=each($sid)){
                                                                list($key,$val)=each($sn);
                                                                    if(in_array($v,$skill)) {
                                                                        echo "<option value=".$v." selected >".$val."";
                                                                    } else {
                                                                        echo "<option value=".$v." >".$val."";
                                                                    }
                                                            }
                                                            
                                                        ?>
                                                    </select><br>

                                      <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user ?>" pattern="[a-zA-Z0-9].{5,}" required>
                                      </div>
                                    <div class="form-inline">
                                      <div class="form-group" style="width: 50%;">
                                        <label for="firstName">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?>" pattern="[a-zA-Z0-9].{5,}" required>
                                      </div>
                                      <div class="form-group" style="width: 49%;">
                                        <label for="lastName">Confirm Password</label>
                                        <input type="password" class="form-control" id="cpassword" name="cpassword" value="<?php echo $password ?>" pattern="[a-zA-Z0-9].{5,}" required>
                                      </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <span class="glyphicon glyphicon-calendar"></span>
                                <h3 class="box-title">&nbsp;Available Schedule</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">                       
                                            <table class="table table-striped" style="text-align:center;">
                                                <tr>
                                                    <th style="text-align:center;">TIME</th>
                                                    <th style="text-align:center;">Monday</th>
                                                    <th style="text-align:center;">Tuesday</th>
                                                    <th style="text-align:center;">Wednesday</th>
                                                    <th style="text-align:center;">Thursday</th>
                                                    <th style="text-align:center;">Friday</th>
                                                    <th style="text-align:center;">Saturday</th>
                                                    <th style="text-align:center;">Sunday</th>
                                                </tr>
                                                <tr>
                                                    <td>9:00 - 10:00 AM</td>
                                                    <?php
                                                        global $dbh;


                                                        try{
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '9:00 - 10:00 AM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[7]" value="9:00 - 10:00 AM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[7]" value="9:00 - 10:00 AM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[7]" value="9:00 - 10:00 AM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[7]" value="9:00 - 10:00 AM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[7]" value="9:00 - 10:00 AM.Sunday.1"></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '10:00 - 11:00 AM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[8]" value="10:00 - 11:00 AM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[8]" value="10:00 - 11:00 AM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[9]" value="10:00 - 11:00 AM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[9]" value="10:00 - 11:00 AM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Tuesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[10]" value="10:00 - 11:00 AM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[10]" value="10:00 - 11:00 AM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[11]" value="10:00 - 11:00 AM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[11]" value="10:00 - 11:00 AM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[12]" value="10:00 - 11:00 AM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[12]" value="10:00 - 11:00 AM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[13]" value="10:00 - 11:00 AM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[13]" value="10:00 - 11:00 AM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[13]" value="10:00 - 11:00 AM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[13]" value="10:00 - 11:00 AM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[13]" value="10:00 - 11:00 AM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[14]" value="10:00 - 11:00 AM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[14]" value="10:00 - 11:00 AM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[14]" value="10:00 - 11:00 AM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[14]" value="10:00 - 11:00 AM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[14]" value="10:00 - 11:00 AM.Sunday.1"></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '11:00 - 12:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[15]" value="11:00 - 12:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[15]" value="11:00 - 12:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[16]" value="11:00 - 12:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[16]" value="11:00 - 12:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[17]" value="11:00 - 12:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[17]" value="11:00 - 12:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[18]" value="11:00 - 12:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[18]" value="11:00 - 12:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[19]" value="11:00 - 12:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[19]" value="11:00 - 12:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[19]" value="11:00 - 12:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[19]" value="11:00 - 12:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[19]" value="11:00 - 12:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[20]" value="11:00 - 12:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[20]" value="11:00 - 12:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[20]" value="11:00 - 12:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[20]" value="11:00 - 12:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[20]" value="11:00 - 12:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[21]" value="11:00 - 12:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[21]" value="11:00 - 12:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[21]" value="11:00 - 12:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[21]" value="11:00 - 12:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[21]" value="11:00 - 12:00 PM.Sunday.1"></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '12:00 - 1:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[22]" value="12:00 - 1:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[22]" value="12:00 - 1:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Monday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[23]" value="12:00 - 1:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[23]" value="12:00 - 1:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[24]" value="12:00 - 1:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[24]" value="12:00 - 1:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[25]" value="12:00 - 1:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[25]" value="12:00 - 1:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[25]" value="12:00 - 1:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[25]" value="12:00 - 1:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[25]" value="12:00 - 1:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[26]" value="12:00 - 1:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[26]" value="12:00 - 1:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[26]" value="12:00 - 1:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[26]" value="12:00 - 1:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[26]" value="12:00 - 1:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[27]" value="12:00 - 1:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[27]" value="12:00 - 1:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[27]" value="12:00 - 1:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[27]" value="12:00 - 1:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[27]" value="12:00 - 1:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[28]" value="12:00 - 1:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[28]" value="12:00 - 1:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[28]" value="12:00 - 1:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[28]" value="12:00 - 1:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[28]" value="12:00 - 1:00 PM.Sunday.1" ></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '1:00 - 2:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[29]" value="1:00 - 2:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[29]" value="1:00 - 2:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[30]" value="1:00 - 2:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[30]" value="1:00 - 2:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[31]" value="1:00 - 2:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[31]" value="1:00 - 2:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[31]" value="1:00 - 2:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[31]" value="1:00 - 2:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[31]" value="1:00 - 2:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[32]" value="1:00 - 2:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[32]" value="1:00 - 2:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[32]" value="1:00 - 2:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[32]" value="1:00 - 2:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[32]" value="1:00 - 2:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[33]" value="1:00 - 2:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[33]" value="1:00 - 2:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[33]" value="1:00 - 2:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[33]" value="1:00 - 2:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[33]" value="1:00 - 2:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[34]" value="1:00 - 2:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[34]" value="1:00 - 2:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[34]" value="1:00 - 2:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[34]" value="1:00 - 2:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[34]" value="1:00 - 2:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[35]" value="1:00 - 2:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[35]" value="1:00 - 2:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[35]" value="1:00 - 2:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[35]" value="1:00 - 2:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[35]" value="1:00 - 2:00 PM.Sunday.1" ></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '2:00 - 3:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[36]" value="2:00 - 3:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[36]" value="2:00 - 3:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[37]" value="2:00 - 3:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[37]" value="2:00 - 3:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[37]" value="2:00 - 3:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[37]" value="2:00 - 3:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[37]" value="2:00 - 3:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[38]" value="2:00 - 3:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[38]" value="2:00 - 3:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[38]" value="2:00 - 3:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[38]" value="2:00 - 3:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[38]" value="2:00 - 3:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[39]" value="2:00 - 3:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[39]" value="2:00 - 3:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[39]" value="2:00 - 3:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[39]" value="2:00 - 3:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[39]" value="2:00 - 3:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[40]" value="2:00 - 3:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[40]" value="2:00 - 3:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[40]" value="2:00 - 3:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[40]" value="2:00 - 3:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[40]" value="2:00 - 3:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[41]" value="2:00 - 3:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[41]" value="2:00 - 3:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[41]" value="2:00 - 3:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[41]" value="2:00 - 3:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[41]" value="2:00 - 3:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[42]" value="2:00 - 3:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[42]" value="2:00 - 3:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[42]" value="2:00 - 3:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[42]" value="2:00 - 3:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[42]" value="2:00 - 3:00 PM.Sunday.1" ></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '3:00 - 4:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[43]" value="3:00 - 4:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[43]" value="3:00 - 4:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[43]" value="3:00 - 4:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[43]" value="3:00 - 4:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[43]" value="3:00 - 4:00 PM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[44]" value="3:00 - 4:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[44]" value="3:00 - 4:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[44]" value="3:00 - 4:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[44]" value="3:00 - 4:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[44]" value="3:00 - 4:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[45]" value="3:00 - 4:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[45]" value="3:00 - 4:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[45]" value="3:00 - 4:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[45]" value="3:00 - 4:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[45]" value="3:00 - 4:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[46]" value="3:00 - 4:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[46]" value="3:00 - 4:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[46]" value="3:00 - 4:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[46]" value="3:00 - 4:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[46]" value="3:00 - 4:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[47]" value="3:00 - 4:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[47]" value="3:00 - 4:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[47]" value="3:00 - 4:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[47]" value="3:00 - 4:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[47]" value="3:00 - 4:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[48]" value="3:00 - 4:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[48]" value="3:00 - 4:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[48]" value="3:00 - 4:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[48]" value="3:00 - 4:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[48]" value="3:00 - 4:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[49]" value="3:00 - 4:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[49]" value="3:00 - 4:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[49]" value="3:00 - 4:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[49]" value="3:00 - 4:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[49]" value="3:00 - 4:00 PM.Sunday.1" ></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '4:00 - 5:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[50]" value="4:00 - 5:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[50]" value="4:00 - 5:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[50]" value="4:00 - 5:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[50]" value="4:00 - 5:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[50]" value="4:00 - 5:00 PM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[51]" value="4:00 - 5:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[51]" value="4:00 - 5:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[51]" value="4:00 - 5:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[51]" value="4:00 - 5:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[51]" value="4:00 - 5:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[52]" value="4:00 - 5:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[52]" value="4:00 - 5:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[52]" value="4:00 - 5:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[52]" value="4:00 - 5:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[52]" value="4:00 - 5:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[53]" value="4:00 - 5:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[53]" value="4:00 - 5:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[53]" value="4:00 - 5:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[53]" value="4:00 - 5:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[53]" value="4:00 - 5:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[54]" value="4:00 - 5:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[54]" value="4:00 - 5:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[54]" value="4:00 - 5:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[54]" value="4:00 - 5:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[54]" value="4:00 - 5:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[55]" value="4:00 - 5:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[55]" value="4:00 - 5:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[55]" value="4:00 - 5:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[55]" value="4:00 - 5:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[55]" value="4:00 - 5:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[56]" value="4:00 - 5:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[56]" value="4:00 - 5:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[56]" value="4:00 - 5:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[56]" value="4:00 - 5:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[56]" value="4:00 - 5:00 PM.Sunday.1"></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '5:00 - 6:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[57]" value="5:00 - 6:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[57]" value="5:00 - 6:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[57]" value="5:00 - 6:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[57]" value="5:00 - 6:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[57]" value="5:00 - 6:00 PM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[58]" value="5:00 - 6:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[58]" value="5:00 - 6:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[58]" value="5:00 - 6:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[58]" value="5:00 - 6:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[58]" value="5:00 - 6:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[59]" value="5:00 - 6:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[59]" value="5:00 - 6:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[59]" value="5:00 - 6:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[59]" value="5:00 - 6:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[59]" value="5:00 - 6:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[60]" value="5:00 - 6:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[60]" value="5:00 - 6:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[60]" value="5:00 - 6:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[60]" value="5:00 - 6:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[60]" value="5:00 - 6:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[61]" value="5:00 - 6:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[61]" value="5:00 - 6:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[61]" value="5:00 - 6:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[61]" value="5:00 - 6:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[61]" value="5:00 - 6:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[62]" value="5:00 - 6:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[62]" value="5:00 - 6:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[62]" value="5:00 - 6:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[62]" value="5:00 - 6:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[62]" value="5:00 - 6:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[63]" value="5:00 - 6:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[63]" value="5:00 - 6:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[63]" value="5:00 - 6:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[63]" value="5:00 - 6:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[63]" value="5:00 - 6:00 PM.Sunday.1"></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '6:00 - 7:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[64]" value="6:00 - 7:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[64]" value="6:00 - 7:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[64]" value="6:00 - 7:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[64]" value="6:00 - 7:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[64]" value="6:00 - 7:00 PM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[65]" value="6:00 - 7:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[65]" value="6:00 - 7:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[65]" value="6:00 - 7:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[65]" value="6:00 - 7:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[65]" value="6:00 - 7:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[66]" value="6:00 - 7:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[66]" value="6:00 - 7:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[66]" value="6:00 - 7:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[66]" value="6:00 - 7:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[66]" value="6:00 - 7:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[67]" value="6:00 - 7:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[67]" value="6:00 - 7:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[67]" value="6:00 - 7:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[67]" value="6:00 - 7:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[67]" value="6:00 - 7:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[68]" value="6:00 - 7:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[68]" value="6:00 - 7:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[68]" value="6:00 - 7:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[68]" value="6:00 - 7:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[68]" value="6:00 - 7:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[69]" value="6:00 - 7:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[69]" value="6:00 - 7:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[69]" value="6:00 - 7:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[69]" value="6:00 - 7:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[69]" value="6:00 - 7:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[70]" value="6:00 - 7:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[70]" value="6:00 - 7:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[70]" value="6:00 - 7:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[70]" value="6:00 - 7:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[70]" value="6:00 - 7:00 PM.Sunday.1"></input></td>';
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
                                                            $query = $dbh->query("SELECT day, time, availability, availabletime, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$empid'");
                                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                            while($row = $query->fetch()){
                                                                $day = $row['day'];
                                                                $time = $row['time'];
                                                                $av = $row['availability'];
                                                                $status = $row['classsched'];

                                                                if($time == '6:00 - 7:00 PM'){
                                                                    if($day == 'Monday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[71]" value="7:00 - 8:00 PM.Monday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[71]" value="7:00 - 8:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[71]" value="7:00 - 8:00 PM.Monday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[71]" value="7:00 - 8:00 PM.Monday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[71]" value="7:00 - 8:00 PM.Monday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Tuesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[72]" value="7:00 - 8:00 PM.Tuesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[72]" value="7:00 - 8:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[72]" value="7:00 - 8:00 PM.Tuesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[72]" value="7:00 - 8:00 PM.Tuesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[72]" value="7:00 - 8:00 PM.Tuesday.1" ></input></td>';
                                                                        }
                                                                    }else if($day == 'Wednesday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[73]" value="7:00 - 8:00 PM.Wednesday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[73]" value="7:00 - 8:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[73]" value="7:00 - 8:00 PM.Wednesday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[73]" value="7:00 - 8:00 PM.Wednesday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[73]" value="7:00 - 8:00 PM.Wednesday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Thursday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[74]" value="7:00 - 8:00 PM.Thursday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[74]" value="7:00 - 8:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[74]" value="7:00 - 8:00 PM.Thursday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[74]" value="7:00 - 8:00 PM.Thursday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[74]" value="7:00 - 8:00 PM.Thursday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Friday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[75]" value="7:00 - 8:00 PM.Friday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[75]" value="7:00 - 8:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[75]" value="7:00 - 8:00 PM.Friday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[75]" value="7:00 - 8:00 PM.Friday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[75]" value="7:00 - 8:00 PM.Friday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Saturday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[76]" value="7:00 - 8:00 PM.Saturday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[76]" value="7:00 - 8:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[76]" value="7:00 - 8:00 PM.Saturday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[76]" value="7:00 - 8:00 PM.Saturday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[76]" value="7:00 - 8:00 PM.Saturday.1"></input></td>';
                                                                        }
                                                                    }else if($day == 'Sunday'){
                                                                        if($av == '1' && $status == '1'){
                                                                            echo '<td><input type="checkbox" name="availabletime[77]" value="7:00 - 8:00 PM.Sunday.1" checked disabled></input></td>';
                                                                        }else if($av == '1'){
                                                                            echo '<input type="hidden" name="availabletime[77]" value="7:00 - 8:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[77]" value="7:00 - 8:00 PM.Sunday.1" checked></input></td>';
                                                                        }else if($av == '0'){
                                                                            echo '<input type="hidden" name="availabletime[77]" value="7:00 - 8:00 PM.Sunday.0"></input>
                                                                            <td><input type="checkbox" name="availabletime[77]" value="7:00 - 8:00 PM.Sunday.1"></input></td>';
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
                        </div>
                    </div>
                </div>
            <input type="submit" name="submit" class="btn btn-primary" onclick="return val();">
            </form>
        </section><!-- /.content -->
    </body>
    <script>
    function val()
        {
        if(form.cpassword.value != form.password.value) {
            alert("Password confirmation does not match.");
            return false;
        }

        return true;

        }

    </script>
</html>

<?php
            }   
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
                
            } 
    if(isset($_POST['submit'])){
        $first = $_POST['fname'];
        $last = $_POST['lname'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $bday = $_POST['birthdate'];
        $pic = $_POST['pic'];
        $user = $_POST['username'];
        $password = $_POST['password'];
        $type = $_POST['type'];
        $string = $_REQUEST['availabletime'];
        $string2 = $_POST['skill'];

        date_default_timezone_set('Asia/Manila');
                        $ctime = date("h:i");
                        $date = date("Y-m-d");
            $msg = '<b>'.$fname." ".$lname."</b> updated his/her profile.";
            $icon = "fa fa-user bg-green";

        echo $db -> editProfile($first, $last, $contact, $address, $email, $bday, $pic, $empid, $user, $password, $type);


        foreach ($string as $name){
            list($time,$day,$availability) = explode(".", $name);
            echo $db -> updateSchedule($empid,$day,$time,$availability);
        }


        echo $db -> deleteSKill($empid);

        foreach($string2 as $skill){
            echo $db -> insertSkill($skill);
        }

        echo $db -> editProfileTimeline($id,$msg,$ctime,$date,$icon);


    }

        
        
    ?>
