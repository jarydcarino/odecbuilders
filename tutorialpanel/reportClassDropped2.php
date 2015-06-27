<?php
    include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID']; 
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
                                    
                                    <span class="glyphicon glyphicon-list"></span>
                                    <h3 class="box-title">&nbsp;List Of Students</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;" ><i class = "fa fa-male"></i> Student Name</th>
                                                <th style="text-align:center;" ><i class = "fa fa-book"></i> Class</th>
                                                <th style="text-align:center;" ><i class = "fa fa-book"></i> Classcard</th>
                                                <th style="text-align:center;" ><i class="fa fa-flag"></i> Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php 
                                                try{
                                                    $query = $dbh -> query("SELECT
                                                        CONCAT(s.firstName, ' ', s.lastName) as `name`,studentID as `sid`,
                                                        skillName as `sn`, t.tutorialID as `tid`, t.status as 'st'
                                                        FROM student s 
                                                        JOIN skills sk ON s.classID = sk.skillID
                                                        JOIN tutorial t ON t.studID = s.studentID
                                                        WHERE instID='$id' AND t.status='dropped'
                                                        ");
                                                    while($row = $query->fetch()){
                                                        echo '<tr>';
                                                        echo '<td>'.$row['name'].'</td>';
                                                        echo '<td>'.$row['sn'].'</td>';
                                                        echo '<td style="text-align:center;"><a href="classcard.php?tid='.$row['tid'].'&name='.$row['name'].'&class='.$row['sn'].'&sid='.$row['sid'].'&type=dropped"><button class="btn btn-success btn-sm"><i class="fa fa-fw fa-book"></i>&nbsp;View Classcard</button></a></td>';
                                                        
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