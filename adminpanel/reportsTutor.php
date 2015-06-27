<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OLOL Renders Admin | Project Report</title>

        <?php 
            $title = "Tutor Report";
            $icon = '<i class="fa fa-clipboard"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
            $ayo = $_GET['eid'];
                        
        ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php" ?>
            <!-- Right side column. Contains the navbar and content of the page -->

                <!-- Main content -->
                <section class="content">
                    <a href="listOfTutors.php"<button class="btn btn-default btn-md">Back to List of Tutors</button></a><br><br>
                    <?php 
                        try{
                            $query = $dbh->query("SELECT CONCAT(e.firstName,' ', e.lastName) as `name` FROM employee e 
                                WHERE e.employeeID='$ayo'");
                            while($row = $query->fetch()){
                                echo '<p>Name:<b> '.$row['name'].'</b></p>';
                            }

                            $query = $dbh->query("SELECT GROUP_CONCAT(s.skillName, ' ') as `sn` FROM skills s 
                                JOIN skillemp sk ON s.skillID = sk.skillID
                                WHERE sk.empID = '$ayo'");
                            while($row = $query->fetch()){
                                echo '<p>Skills: <b>'.$row['sn'].'</b></p>';
                            }
                        }catch(PDOException $e){

                        }
                    ?>
                    
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        Ongoing
                                    </h3>
                                    <p>
                                        Classes
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                                <a href="reportsTutor.php?type=ongoing&eid=<?php echo $ayo ?>" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        Finished
                                    </h3>
                                    <p>
                                        Classes
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-flag"></i>
                                </div>
                                <a href="reportsTutor.php?type=finished&eid=<?php echo $ayo ?>" class="small-box-footer">
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
                                    <i class="fa fa-exclamation"></i>
                                </div>
                                <a href="reportsTutor.php?type=dropped&eid=<?php echo $ayo ?>" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class ="box-title"><i class="fa fa-clipboard"></i> Tutor Report
                                        <?php
                                        $type = $_GET['type'];
                                        if($type == 'ongoing'){
                                            echo '<a href="pdf/tutor_individual_o.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }else if($type == 'finished'){
                                            echo '<a href="pdf/tutor_individual_f.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }else if($type == 'dropped'){
                                            echo '<a href="pdf/tutor_individual_d.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }else{
                                            echo '<a href="pdf/tutor_individual.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }
                                        ?>
                                    </h3>
                                   
                                </div>
                                    <div class="box-body table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Student Name</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Tutor</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-book"></i> Class</th>
                                                                                  
                                                <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Remaining Sessions</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Status</th>
                                                
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if($type == 'all'){
                                                    $eid = $_GET['eid'];
                                                    $type = $_GET['type'];

                                                    
                                                        
                                                        $query = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `student`, 
                                                            sk.skillName as `sn`, sk.session as `sess`,s.studentID as `sid`,t.tutorialID as `tid`,
                                                            CONCAT(e.firstName, ' ', e.lastName) as `tutor`, status
                                                            FROM student s JOIN tutorial t ON s.studentID = t.studID
                                                            JOIN employee e ON e.employeeID =  t.empID
                                                            JOIN skills sk ON sk.skillID = t.classID WHERE s.instID = '$eid';
                                                            ");

                                                        while($row = $query->fetch()){
                                                            $status = $row['status'];
                                                            echo '<tr>';
                                                            echo '<td>'.$row['student'].'</td>';
                                                            echo '<td>'.$row['tutor'].'</td>';
                                                            echo '<td>'.$row['sn'].'</td>';


                                                            
                                                                if($type == 'finished'){
                                                                    
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'&type=finished"><span class="badge bg-green">View Classcard</span></a></td>';
                                                                    echo '<td><span class="badge bg-green">'.$status.'</span></td>';
                                                                }else if($type == 'ongoing'){
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'&type=ongoing"><span class="badge bg-yellow">'.$row['sess'].' Sessions</span></a></td>';
                                                                    echo '<td><span class="badge bg-blue">'.$status.'</span></td>';
                                                                }else if($type == 'dropped'){
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'&type=dropped"><span class="badge bg-red">View Classcard</span></a></td>';
                                                                    echo '<td><span class="badge bg-red">'.$status.'</span></td>';
                                                                }else{
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'&type=all"><span class="badge bg-yellow">'.$row['sess'].' Sessions</span></a></td>';
                                                                    echo '<td><span class="badge bg-red">'.$status.'</span></td>';
                                                                }

                                                           
                                                            echo '</tr>';
                                                    }

                                                }else if(isset($_GET['type'])){
                                                    $eid = $_GET['eid'];
                                                    $type = $_GET['type'];

                                                    
                                                        
                                                        $query = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `student`, 
                                                            sk.skillName as `sn`, sk.session as `sess`,s.studentID as `sid`,t.tutorialID as `tid`,
                                                            CONCAT(e.firstName, ' ', e.lastName) as `tutor`, status
                                                            FROM student s JOIN tutorial t ON s.studentID = t.studID
                                                            JOIN employee e ON e.employeeID =  t.empID
                                                            JOIN skills sk ON sk.skillID = t.classID WHERE s.instID = '$eid' AND status='$type';
                                                            ");

                                                        while($row = $query->fetch()){
                                                            $status = $row['status'];
                                                            echo '<tr>';
                                                            echo '<td>'.$row['student'].'</td>';
                                                            echo '<td>'.$row['tutor'].'</td>';
                                                            echo '<td>'.$row['sn'].'</td>';


                                                            
                                                                if($status == 'finished'){
                                                                    echo '<td><span class="badge bg-green">'.$status.'</span></td>';
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'&type=finished"><span class="badge bg-green">View Classcard</span></a></td>';
                                                                }else if($status == 'ongoing'){
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'&type=ongoing"><span class="badge bg-yellow">'.$row['sess'].' Sessions</span></a></td>';
                                                                    echo '<td><span class="badge bg-blue">'.$status.'</span></td>';
                                                                }else if($status == 'dropped'){
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'&type=dropped"><span class="badge bg-red">View Classcard</span></a></td>';
                                                                    echo '<td><span class="badge bg-red">'.$status.'</span></td>';
                                                                }

                                                           
                                                            echo '</tr>';
                                                    }


                                                    
                                                }else{
                                                    try{
                                                       $eid = $_GET['eid'];
                                                                                                           
                                                        $query = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `student`, 
                                                            sk.skillName as `sn`, sk.session as `sess`, s.studentID as `sid`,
                                                            CONCAT(e.firstName, ' ', e.lastName) as `tutor`, status, t.tutorialID as `tid`
                                                            FROM student s JOIN tutorial t ON s.studentID = t.studID
                                                            JOIN employee e ON e.employeeID =  t.empID
                                                            JOIN skills sk ON sk.skillID = t.classID WHERE s.instID = '$eid';
                                                            ");

                                                        while($row = $query->fetch()){
                                                            $status = $row['status'];
                                                            echo '<tr>';
                                                            echo '<td>'.$row['student'].'</td>';
                                                            echo '<td>'.$row['tutor'].'</td>';
                                                            echo '<td>'.$row['sn'].'</td>';
                                                            
                                                                if($status == 'finished'){
                                                                    echo '<td><span class="badge bg-green">'.$status.'</span></td>';
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'"><span class="badge bg-green"><i class="fa fa-fw fa-book"></i> View Classcard</span></a></td>';
                                                                }else if($status == 'ongoing'){
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'"><span class="badge bg-yellow"><i class="fa fa-fw fa-book"></i> '.$row['sess'].' Sessions</span></a></td>';
                                                                    echo '<td><span class="badge bg-blue">'.$status.'</span></td>';
                                                                }else if($status == 'dropped'){
                                                                    echo '<td><a href="classLogs.php?eid='.$eid.'&sid='.$row['sid'].'&tid='.$row['tid'].'"><span class="badge bg-red"><i class="fa fa-fw fa-book"></i> View Classcard</span></a></td>';
                                                                    echo '<td><span class="badge bg-red">'.$status.'</span></td>';
                                                                }
                                                           echo '</tr>';
                                                    }
                                                    

                                                    }catch(PDOException $ex){
                                                        echo $ex->getMessage();
                                                    }
                                                }
                                            ?>
                                            
                                        </tbody>
                                    </table>

                                    </div>
                                


                            </div><!--primary-->
                        </div>
                    </div><!-- /.row -->

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