<?php
    include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID']; 
?>



<!DOCTYPE html>
<html>
    <head>

       <?php
            $icon = '<i class="fa fa-print"></i>'; 
            $title = "Reports";
            include_once "includes/head.php" ;
        ?>

    </head>
    <body class="skin-blue">
       
                <?php include_once "includes/navigation.php" ?>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        Ongoing
                                    </h3>
                                    <p>
                                        Classes
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <a href="reportClassOngoing.php" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        Finished
                                    </h3>
                                    <p>
                                        Classes
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="reportClassFinished.php" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        Dropped
                                    </h3>
                                    <p>
                                        Classes
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-times"></i>
                                </div>
                                <a href="reportClassDropped.php" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class ="box-title"><i class="fa fa-clipboard"></i> Ongoing Classes <a href="pdf/class_reports_ongoing.php" target="_blank"><button class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a></h3>                                   
                                  
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;" ><i class = "fa fa-male"></i> Student Name</th>
                                                <th style="text-align:center;" ><i class = "fa fa-book"></i> Class</th>
                                                <th style="text-align:center;" ><i class = "fa fa-calendar"></i> Days</th>
                                                <th style="text-align:center;" ><i class = "fa fa-calendar"></i> Time</th>
                                                <th style="text-align:center;"><i class="fa fa-book"></i> Sessions</th>
                                                <th style="text-align:center;" ><i class = "fa fa-book"></i> Classcard</th>
                                                <th style="text-align:center;" ><i class="fa fa-flag"></i> Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php 
                                                try{
                                                    $query = $dbh -> query("SELECT
                                                        CONCAT(firstName, ' ', lastName) as `name`,studentID as `sid`,
                                                        GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`, 
                                                        GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`,
                                                        skillName as `sn`, t.tutorialID as `tid`, t.status as 'st', s.session as `session`
                                                        FROM student s 
                                                        JOIN schedule ss ON s.studentID = ss.studID 
                                                        JOIN skills sk ON s.classID = sk.skillID
                                                        JOIN tutorial t ON t.studID = s.studentID
                                                        WHERE instID='$id' AND ss.classsched=1 AND t.status = 'ongoing'
                                                        GROUP BY ss.studID");
                                                    while($row = $query->fetch()){
                                                        echo '<tr>';
                                                        echo '<td>'.$row['name'].'</td>';
                                                        echo '<td>'.$row['sn'].'</td>';
                                                        echo '<td>'.$row['schedule'].'</td>';
                                                        echo '<td>'.$row['time'].'</td>';
                                                        echo "<td style='text-align:center;'><span class='badge bg-green'>".$row['session']."</span></td>";

                                                        echo '<td style="text-align:center;"><a href="classcard.php?tid='.$row['tid'].'&name='.$row['name'].'&class='.$row['sn'].'&sid='.$row['sid'].'&type=ongoing"><button class="btn btn-info btn-sm"><i class="fa fa-fw fa-book"></i>&nbsp;View Classcard</button></a></td>';
                                                        
                                                        if($row['st'] == 'ongoing'){
                                                            echo "<td style='text-align:center;'><span class='badge bg-blue'>".$row['st']."</span></td>";
                                                        }else if($row['st'] == 'dropped'){
                                                            echo "<td style='text-align:center;'><span class='badge bg-red'>".$row['st']."</span></td>";
                                                        }else if($row['st'] == 'finished'){
                                                            echo "<td style='text-align:center;'><span class='badge bg-yellow'>".$row['st']."</span></td>";
                                                        }
                                                        echo '</tr>';
                                                    }
                                                }catch(PDOException $e){

                                                }
                                           ?> 

                                        
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->   
                                


                            </div><!--primary-->
                        </div>
                    </div><!-- /.row -->

                   

                   

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->



       

    </body>
</html>