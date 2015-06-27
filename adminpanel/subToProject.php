<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Assign Draftsman";
            $icon = '<i class="fa fa-edit"></i>';
            $pid = $_GET['id'];
            $aa = $_GET['at'];
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

                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">

                                <div class="box-header">
                                    <a href="assignDraftsman.php"><br>&nbsp;&nbsp;&nbsp; < < < Back to Added Projects</a><br>
                                    <span class="glyphicon glyphicon-briefcase"></span>
                                    <?php

                                        try{


                                            $query = $dbh->query("SELECT projectName as `pn`, clientName as `cn`, contactNum as `con`,
                                                location as `l`, totalNumHours as `th`, skillName as `sr`, startdate as `sdate`, duedate as `ddate`
                                                 FROM project p JOIN skills sk ON sk.skillID = p.skillReq WHERE projectID='$pid' ");
                                            $query -> setFetchMode(PDO::FETCH_ASSOC);

                                            while($row = $query -> fetch()){
                                                $pn = $row['pn'];
                                                $cn = $row['cn'];
                                                $con = $row['con'];
                                                $l = $row['l'];
                                                $th = $row['th'] / 60;
                                                $sr = $row['sr'];
                                                $sdate = $row['sdate'];
                                                $ddate = $row['ddate'];

                                                $s = date("F d, Y",strtotime($sdate));
                                                $d = date("F d, Y",strtotime($ddate));

                                               
                                                echo '<h3 class="box-title"><b>&nbsp;'.$pn.'</b></h3>';
                                                
                                            

                                            }

                                        }catch(PDOException $ex){
                                          echo $ex->getMessage();
                                          die();
                                        }

                                    ?>
                                                                       
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">

                                     <?php 
                                        echo '<div style="float: left; display:block;"><p>Client: <b>&nbsp;'.$cn.'</b></p>';
                                        echo '<p>Contact: <b>&nbsp;'.$con.'</b></p>';
                                        echo '<p>Location: <b>&nbsp;'.$l.'</b></p>';
                                        echo '<p>Total Number of Hours: <b>&nbsp;'.$th.' hours</b></p></div><br><br><br><br><br><br><br>';
                                        echo '<div style="margin-left:500px; margin-top:-100px;"><p>Skill Required: <b>&nbsp;'.$sr.'</b></p>';
                                        echo '<p>Start Date: <b>&nbsp;'.$s.'</b></p>';
                                        echo '<p>Due Date: <b>&nbsp;'.$d.'</b></p></div>';
                                    ?>
                                   
                                    
                                    
                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>
                                            <tr role="row">

                                                <th colspan="1" rowspan="1"><i class="fa fa-camera-retro"></i> </th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user-md"></i> Name</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-legal"></i> Available Time</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Options</th>
                                        </thead>
                                         <tbody>
                                            <?php echo $db -> availableDraftsmen() ?>
                                            
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->   
                                


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

        


        <!-- jQuery 2.0.2 -->
       

    </body>
</html>

<?php
    if(isset($_GET['eid'])){
        $eid = $_GET['eid'];
        $pid = $_GET['id'];
        
        $query = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `n` FROM employee WHERE employeeID='$eid'");
        $query2 = $dbh->query("SELECT projectName as `pn`, draftsmanID as `dmid` FROM project WHERE projectID='$pid'");
        
        date_default_timezone_set('Asia/Manila');
        $time = date("h:i");
        $date = date("Y-m-d");
        $icon = "fa fa fa-user bg-orange";

        while($row = $query->fetch()){
            while($row2 = $query2->fetch()){
                $dmid = $row2['dmid'];
                $msg = '<b>'.$row['n']."</b> has been assigned to the <b>PROJECT: ".$row2['pn'].'</b>';
                echo $db ->subDrafts($pid,$eid,$id,$time,$date,$msg,$icon,$dmid);
            }
        }
        
    }
?>
