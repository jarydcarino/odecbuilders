<?php
     include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID'];
     $icon = '<i class="fa fa-folder"></i>';
     $title = "Overview";
    date_default_timezone_set('Asia/Manila');
    $date=date('Y-m-d');
    $nt = $_GET['nt'];

    global $dbh;
    try{
        $query = $dbh->prepare("UPDATE notification SET status='Seen' WHERE notifID=:nt ");
        $query -> bindParam(":nt", $nt);
        $query -> execute();
    }catch (PDOException $e) {
    
    }
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
                                            <label><br>Project Name:</label>
                                            <select name="option" class="form-control">
                                             <?php echo $db -> fetchProjects($id); ?>
                                            </select>
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
                                                    $query = $dbh->query("SELECT COUNT(projectID) AS `count`, totalNumHours as `hours` FROM project WHERE `draftsmanID` = '$id' AND status='ongoing'");
                                                    $query -> execute();
                                                    $row = $query -> fetch();
                                                    if($row["count"] > 0){
                                                      echo  "<input class='btn btn-danger btn-lg' type='submit' value='TIME IN' name='punchin'/>
                                                        <input class='btn btn-default btn-lg' type='submit' value='TIME OUT' name='punchout' disabled/>";
                                                    }elseif($row["count"] == 0){
                                                      echo  "<input class='btn btn-danger btn-lg' type='submit' value='TIME IN' name='punchin' disabled/>
                                                        <input class='btn btn-default btn-lg' type='submit' value='TIME OUT' name='punchout' disabled/>";
                                                    }else{

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
                                            <th colspan="1" rowspan="1"><i class="fa fa-map-marker"></i> Location</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Due Date</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-check-circle-o"></i> Status</th> 
                                    </thead>
                                        <tbody>
                                             <?php echo $db -> fetchOngoingProjects($id); ?>
                                    </tbody></table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <ul class="pagination pagination-sm no-margin pull-right">
                                        <li><a href="#">«</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">»</a></li>
                                    </ul>
                                </div>
                            </div><!-- /.box -->
                        </div>
                        <?php

                        $query = $dbh->query("SELECT TIMESTAMPDIFF(DAY,CURDATE(),duedate) as `diff`,projectName as `pn` FROM project WHERE `draftsmanID` = '$id' AND status = 'ongoing'");
                        $query -> execute();
                        $temp = 1;
                        while($row = $query->fetch()){
                            if($row["diff"] == 1){
                                if($temp == 1){
                                echo"<div class='col-xs-6'>
                                <div class='box'>
                                <div class='box-header'>
                                <h3 class='box-title'><i class='fa fa-warning'></i> NOTICE!!</h3>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;your project:".$row['pn']."is due tommorow      
                                <div class='box-body'>
                                </div>
                                </div>
                                </div>";
                                $temp = 2;
                                }else{
                                    echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;your project:".$row['pn']."is due tommorow      
                                    <div class='box-body'>
                                    </div>
                                    </div>
                                    </div>";
                                }
                            }else{
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
    if(isset($_POST['punchin'])){
            
            $id = $_SESSION['empID'];
            $date = $_POST['date'];
            $choice = $_POST['option'];


            $db -> timeIn($id,$choice,$date);

          }
?>