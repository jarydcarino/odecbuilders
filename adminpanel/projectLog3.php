
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

            $pid = $_GET['pid'];
            $eid = $_GET['eid'];
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
                        $query = $dbh->query("SELECT projectName as `pn`,CONCAT(firstName,' ',lastName) as `name`, totalNumHours as `th`,
                            startdate as `sdate`, duedate as `ddate`
                            FROM project p JOIN employee e ON p.draftsmanID=e.employeeID WHERE projectID='$pid'");
                        while($row = $query->fetch()){
                            $s = date("F d, Y",strtotime($row['sdate']));
                            $d = date("F d, Y",strtotime($row['ddate']));
                            $hours = floor($row['th'] / 60);
                            $minutes = ($row['th'] % 60);

                            echo '<p style="text-align:left;"><b>Project Name: </b>'.$row['pn'].'</p>';
                            echo '<p style="text-align:left;"><b>Draftsman: </b>'.$row['name'].'</p>';
                            echo '<p style="text-align:left;"><b>Time Left: </b>'.$hours.' hrs and '.$minutes.' minutes</p>';
                            echo '<p style="text-align:left;"><b>Start Date: </b>'.$s.'</p>';
                            echo '<p style="text-align:left;"><b>Due Date: </b>'.$d.'</p>';
                        }
                    ?>
                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time In</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time Out</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Minutes</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Date</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            <?php 
                                            try{
                                                $query = $dbh->query("SELECT p.proj_ID as `pid`,
                                                                    p.timeIn as `timein`, p.timeOUt as `timeout`, p.date as `date`,
                                                                    hrWork as `work`
                                                                    FROM projwork p 
                                                                    WHERE p.proj_ID = $pid;
                                                                    ");
                                                $query -> setFetchMode(PDO::FETCH_ASSOC);
                                                while($row = $query->fetch()){
                                                    $d = date("F d, Y",strtotime($row['date']));
                                                    $h = floor($row['work'] / 60);
                                                    $m = ($row['work'] % 60);
                                                    $ti = date("h:i A",strtotime($row['timein']));
                                                    $to = date("h:i A",strtotime($row['timeout']));
                                                    echo '<tr>';
                                                    echo '<td>'.$ti.'</a></td>';
                                                    echo '<td>'.$to.'</td>';
                                                    echo '<td><b>'.$h.' hrs and '.$m.' minutes</b></td>';
                                                    echo '<td>'.$d.'</td>';
                                                    echo '</tr>';
                                                    }

                                                }catch(PDOException $ex){
                                                    echo $ex->getMessage();
                                                }

                                            ?>
                                             
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
                                <?php if($type=='acc'){     
                                    echo '<a href="accomplishedProject.php?id='.$eid.'"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>';
                                }elseif($type == 'ongoing'){
                                   echo' <a href="index.php"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>';
                                }
                                ?>
                </fieldset> 



            </form>
        </section><!-- /.content -->
    </body>
</html>



