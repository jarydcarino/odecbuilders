<?php
     include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID'];
     $icon = '<i class="fa fa-dashboard"></i>';
     $title = "Overview";
    date_default_timezone_set('Asia/Manila');
    $date=date('Y-m-d');
?>

<!DOCTYPE html>
<html>
    <head>
        <?php

         include_once "includes/head.php"; 

         ?>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php include_once "includes/navigation.php" ?>


            <!-- Right side column. Contains the navbar and content of the page -->
            <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <div class="box-title">Project TimeIn/TimeOut</div><br>
                                    <div class="box-body">
                                         <div class="form-group">



                                         <form method="POST" action="">
                                            <label><br>Project Name:<br> <?php echo $db -> fetchprojm($id); ?></label>
                                            <?php
                       

                                                
                                                        if(isset($_GET['s'])){
                                                            echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                                <strong>Success!</strong> Time In Project Successful.
                                                            </div>';

                                                        }
                                                        
                                                    ?>
                                            <div class="box-footer">
                                                <label style="margin-left:140px;"></label><br>
                                                
                                                <?php
                                                     date_default_timezone_set('Asia/Manila');
                                                     $date=date('Y-m-d');
                                                     $time=date('G:i A');
                                                ?>

                                                <input type="hidden" name="date" value="<?php echo $date ?>"/>
                                                <input type="hidden" name="time" value="<?php echo $time ?>"/>
                                                <?php 
                                                    $pid = $_GET['pid'];
                                                    $query = $dbh->query("SELECT COUNT(projectID) AS `count`, totalNumHours as `hours`, duedate as `dd` FROM project WHERE `draftsmanID` = '$id' AND status='ongoing' AND projectID='$pid'");
                                                    $query -> execute();
                                                    $row = $query -> fetch();
                                                    $d = date('Y-m-d');
                                                    if($row["count"] > 0 && ($row['hours'] == 0 || $row['dd'] == $d)){
                                                      echo  "
                                                        <input class='btn btn-warning btn-lg' type='submit' value='Request for Extension' name='request'/>";
                                                    }else if($row["count"] > 0 && ($row['hours'] > 0 || $row['dd'] < $d)){
                                                      echo  "<center>
                                                             <input class='btn btn-default btn-md' type='submit' value='TIME IN' name='punchin'  disabled/>
                                                              <input class='btn btn-danger btn-md' type='submit' value='TIME OUT' name='punchout'/></center>
                                                        ";
                                                    }else if($row["count"] == 0){
                                                      echo  "<input class='btn btn-danger btn-lg' type='submit' value='TIME IN' name='punchin' disabled/>
                                                        <input class='btn btn-default btn-lg' type='submit' value='TIME OUT' name='punchout' disabled/>
                                                        ";
                                                    }

                                                ?>
                                            </div>     
                                      </div>
                                    </div>                                  
                                </div><!-- /.box-header -->
                                </form>
                            </div><!-- /.box -->
                        </div>



                        <div class="col-xs-6">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><i class="fa fa-tasks"></i> List of Ongoing Projects</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr role="row">
                                            <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Name</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Due Date</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-check-circle-o"></i> Time Remaining</th>
                                            <th colspan="1" rowspan="1"><i class="fa fa-check-circle-o"></i> Logs</th>  
                                    </thead>
                                        <tbody>
                                             <?php echo $db -> fetchOngoingProjects($id); ?>
                                    </tbody></table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                               
                                    <?php

                                    $query = $dbh->query("SELECT TIMESTAMPDIFF(DAY,CURDATE(),duedate) as `diff`,projectName as `pn` FROM project WHERE `draftsmanID` = '$id' AND status = 'ongoing'");
                                    $query -> execute();
                                    $temp = 1;
                                    while($row = $query->fetch()){
                                        if($row['diff'] == 1){
                                            if($temp == 1){
                                            echo"<div class='col-xs-6'>
                                            <div class='box'>
                                            <div class='box-header'>
                                            <h3 class='box-title'><i class='fa fa-warning'></i> NOTICE!!</h3>
                                             
                                            <div class='box-body'>
                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Project: ".$row['pn']." is due tommorow.  
                                            ";
                                            $temp = 2;
                                            }else{
                                                echo "     
                                                <div class='box-body'>
                                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br>Your Project: ".$row['pn']." is due tommorow. 
                                                ";
                                            }
                                        }elseif($row['diff'] == 0){
                                            if($temp == 1){
                                            echo"<div class='col-xs-6'>
                                            <div class='box'>
                                            <div class='box-header'>
                                            <h3 class='box-title'><i class='fa fa-warning'></i> NOTICE!!</h3></br>
                                                
                                            <div class='box-body'>
                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Project: ".$row['pn']." is due today. 
                                            ";
                                            $temp = 2;
                                            }else{
                                                echo "     
                                                <div class='box-body'>
                                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br>Your Project: ".$row['pn']." is due today. 
                                                ";
                                            }
                                         //do nothing  
                                        }
                                    }
                                ?>
                            
                       </div>
                       </div>
                       </div>
                </section><!-- /.content -->
    </body>
</html>

<?php
    global $dbh;
    if(isset($_POST['punchout'])){
            
            $id = $_SESSION['empID'];
            $choice=$_POST['option'];
            $db -> timeOut($id,$choice);  

          }
?>