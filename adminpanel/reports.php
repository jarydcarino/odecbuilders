<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OLOL Renders Admin | Project Report</title>

        <?php 
            $title = "Draftsman Report";
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
                    <a href="listDraftsman.php"<button class="btn btn-default btn-md">Back to List of Draftsman</button></a><br><br>
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
                                        Projects
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                                <a href="reports.php?type=ongoing&eid=<?php echo $ayo ?>" class="small-box-footer">
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
                                        Projects
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-flag"></i>
                                </div>
                                <a href="reports.php?type=finished&eid=<?php echo $ayo ?>" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        Onhold
                                    </h3>
                                    <p>
                                        Projects
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-coffee"></i>
                                </div>
                                <a href="reports.php?type=hold&eid=<?php echo $ayo ?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        Cancelled
                                    </h3>
                                    <p>
                                        Projects
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-exclamation"></i>
                                </div>
                                <a href="reports.php?type=cancelled&eid=<?php echo $ayo ?>" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class ="box-title"><i class="fa fa-clipboard"></i> Draftsman Report 
                                        <?php
                                        $type = $_GET['type'];
                                        if($type == 'ongoing'){
                                            echo '<a href="pdf/draftsman_individual_o.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }else if($type == 'finished'){
                                            echo '<a href="pdf/draftsman_individual_f.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }else if($type == 'hold'){
                                            echo '<a href="pdf/draftsman_individual_h.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }else if($type == 'cancelled'){
                                            echo '<a href="pdf/draftsman_individual_c.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }else{
                                            echo '<a href="pdf/draftsman_individual.php?eid='.$ayo.'" target="_blank"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a>';
                                        }
                                        ?>
                                        
                                    </h3>
                                   
                                </div>
                                    <div class="box-body table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Title</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Draftsman</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-legal"></i> Skill</th>
                                                                                  
                                                <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Due Date</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Owner</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Status</th>
                                                <th colspan="1" rowspan="1"><span class="glyphicon glyphicon-stats"></span> Logs</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 

                                                if($type == 'all'){
                                                    $ayo = $_GET['eid'];
                                                    $type = $_GET['type'];

                                                    
                                                        
                                                        $query = $dbh->query("SELECT * FROM
                                                            (SELECT projectName as `pn`, projectID as `pid`,
                                                            clientName as `client`, skillName as `sn`,
                                                            CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
                                                            location,
                                                            status, duedate
                                                            FROM project p 
                                                            JOIN employee e ON p.draftsmanID = e.employeeID
                                                            JOIN skills s ON p.skillReq = s.skillID
                                                            WHERE e.employeeID='$ayo') as `tablename`
                                                            ;");

                                                        while($row = $query->fetch()){
                                                            $status = $row['status'];
                                                            $d = date("F d, Y",strtotime($row['duedate']));
                                                            
                                                            echo '<tr>';
                                                            echo '<td><b>'.$row['pn'].'</b></td>';
                                                            echo '<td><i>'.$row['draftsman'].'</i></td>';
                                                            echo '<td>'.$row['sn'].'</td>';
                                                            echo '<td>'.$d.'</td>';
                                                            echo '<td>'.$row['client'].'</td>';
                                                            
                                                            if($status == 'finished'){
                                                                echo '<td><span class="badge bg-green">'.$status.'</span></td>';
                                                            }else if($status == 'ongoing'){
                                                                echo '<td><span class="badge bg-blue">'.$status.'</span></td>';
                                                            }else if($status == 'cancelled'){
                                                                echo '<td><span class="badge bg-red">'.$status.'</span></td>';
                                                            }else if($status == 'hold'){
                                                                echo '<td><span class="badge bg-yellow">'.$status.'</span></td>';
                                                            }

                                                            echo '<td><a href="logs.php?id='.$row['pid'].'&eid='.$ayo.'&type=all"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><span class="glyphicon glyphicon-stats"></span>&nbsp;View Logs</button></a></td>';
                                                            
                                                            echo '</tr>';
                                                    }
                                                }else if(isset($_GET['type'])){
                                                    $ayo = $_GET['eid'];
                                                    $type = $_GET['type'];

                                                    
                                                        
                                                        $query = $dbh->query("SELECT * FROM
                                                            (SELECT projectName as `pn`, projectID as `pid`,
                                                            clientName as `client`, skillName as `sn`,
                                                            CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
                                                            location,
                                                            status, duedate
                                                            FROM project p 
                                                            JOIN employee e ON p.draftsmanID = e.employeeID
                                                            JOIN skills s ON p.skillReq = s.skillID
                                                            WHERE status = '$type' AND e.employeeID='$ayo') as `tablename`
                                                            ;");

                                                        while($row = $query->fetch()){
                                                            $status = $row['status'];
                                                            $d = date("F d, Y",strtotime($row['duedate']));
                                                            
                                                            echo '<tr>';
                                                            echo '<td><b>'.$row['pn'].'</b></td>';
                                                            echo '<td><i>'.$row['draftsman'].'</i></td>';
                                                            echo '<td>'.$row['sn'].'</td>';
                                                            echo '<td>'.$d.'</td>';
                                                            echo '<td>'.$row['client'].'</td>';
                                                            
                                                            if($status == 'finished'){
                                                                echo '<td><span class="badge bg-green">'.$status.'</span></td>';
                                                            }else if($status == 'ongoing'){
                                                                echo '<td><span class="badge bg-blue">'.$status.'</span></td>';
                                                            }else if($status == 'cancelled'){
                                                                echo '<td><span class="badge bg-red">'.$status.'</span></td>';
                                                            }else if($status == 'hold'){
                                                                echo '<td><span class="badge bg-yellow">'.$status.'</span></td>';
                                                            }

                                                            echo '<td><a href="logs.php?id='.$row['pid'].'&eid='.$ayo.'&type='.$type.'"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><span class="glyphicon glyphicon-stats"></span>&nbsp;View Logs</button></a></td>';
                                                            
                                                            echo '</tr>';
                                                    }


                                                    
                                                }else{
                                                    try{
                                                        $query = $dbh->query("SELECT * FROM
                                                                            (SELECT projectName as `pn`, projectID as `pid`,
                                                                            clientName as `client`, skillName as `sn`,
                                                                            CONCAT(e.firstName,' ', e.lastName) as `draftsman`,
                                                                            location,
                                                                            status, duedate
                                                                            FROM project p 
                                                                            JOIN employee e ON p.draftsmanID = e.employeeID
                                                                            JOIN skills s ON p.skillReq = s.skillID
                                                                            WHERE e.employeeID='$ayo') as `tablename`
                                                                            ;
                                                                            ");
                                                        $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                        while($row = $query->fetch()){
                                                           
                                                            $status = $row['status'];

                                                            $d = date("F d, Y",strtotime($row['duedate']));
                                                            
                                                            echo '<tr>';
                                                            echo '<td><b>'.$row['pn'].'</b></td>';
                                                            echo '<td><i>'.$row['draftsman'].'</i></td>';
                                                            echo '<td>'.$row['sn'].'</td>';
                                                            echo '<td>'.$d.'</td>';
                                                            echo '<td>'.$row['client'].'</td>';
                                                            
                                                            if($status == 'finished'){
                                                                echo '<td><span class="badge bg-green">'.$status.'</span></td>';
                                                            }else if($status == 'ongoing'){
                                                                echo '<td><span class="badge bg-blue">'.$status.'</span></td>';
                                                            }else if($status == 'cancelled'){
                                                                echo '<td><span class="badge bg-red">'.$status.'</span></td>';
                                                            }else if($status == 'hold'){
                                                                echo '<td><span class="badge bg-yellow">'.$status.'</span></td>';
                                                            }

                                                            echo '<td><a href="logs.php?id='.$row['pid'].'&eid='.$ayo.'&type='.$type.'"><button class="btn btn-info btn-sm" style="width:100%;" type="submit"><i class="fa fa-calendar"></i>&nbsp;View Logs</button></a></td>';
                                                            
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