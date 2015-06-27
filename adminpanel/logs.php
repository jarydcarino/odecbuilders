
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "View Logs";
            $icon = '<i class="fa fa-edit"></i>';
            
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";

            $pid = $_GET['id'];
            $ayo = $_GET['eid'];
            $type = $_GET['type'];
        ?>
       
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php include_once "includes/navigation.php" ?>

                <!-- Main content -->
        <section class="content">
            <form id="msform" method="POST" style="width:80%; ">
            <!-- progressbar -->
                
                <!-- fieldsets -->

                <fieldset style="margin-bottom:50px;">

                    <h2 class="fs-title">Project Logs</h2>
                    <?php
                        $query = $dbh->query("SELECT projectName as `pn`,CONCAT(firstName,' ',lastName) as `name` FROM project p JOIN employee e ON p.draftsmanID=e.employeeID WHERE projectID='$pid'");
                        while($row = $query->fetch()){
                            echo '<p style="text-align:left;">PROJECT: <b>'.$row['pn'].'</b></p>';
                            echo '<p style="text-align:left;">DRAFTSMAN: <b>'.$row['name'].'</b></p>';
                        }
                    ?>
                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time In</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time Out</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Minutes</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Date</th>
                                        </thead>
                                         <tbody>
                                            <?php echo $db -> fetchLogs() ?>  
                                        </tbody>
                                        <tfoot>
                                            <?php
                                                $query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE proj_id = '$pid'
                                                                ");
                                                $row2 = $query2->fetch();

                                                $h = floor($row2['consumed'] / 60);
                                                $m = ($row2['consumed'] % 60);
                                                echo '<td colspan = 2 style="text-align:right;"><b>Total:</b></td>';
                                                echo '<td><b>'.$h.' hrs and '.$m.' minutes</b></td><td></td>';
                                            ?> 
                                            
                                            
                                        </tfoot>
                                    </table>
                    <?php
                        if($type == 'ongoing'){
                            echo '<a href="reports.php?eid='.$ayo.'&type=ongoing"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>';
                        }else if($type == 'finished'){
                            echo '<a href="reports.php?eid='.$ayo.'&type=finished"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>';
                        }else if($type == 'hold'){
                            echo '<a href="reports.php?eid='.$ayo.'&type=hold"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>';
                        }else if($type == 'cancelled'){
                            echo '<a href="reports.php?eid='.$ayo.'&type=cancelled"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>';
                        }else{
                            echo '<a href="reports.php?eid='.$ayo.'&type=all"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>';
                        }
                    
                    ?>
                </fieldset> 



            </form>
        </section><!-- /.content -->
    </body>
</html>



