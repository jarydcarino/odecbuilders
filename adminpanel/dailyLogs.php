
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Daily Logs";
            $icon = '<i class="fa fa-edit"></i>';
            
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";

            $did = $_GET['id'];
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
                    <?php
                        $query = $dbh->query("SELECT CONCAT(firstName,' ',lastName) as `name`
                            FROM employee WHERE employeeID='$did'");
                        $row = $query->fetch();
                    ?>
                    <h2 class="fs-title">Daily Logs &nbsp;</h2>
                    <a href="pdf/daily_log.php?did=<?php echo $did ?>" target="_blank"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-file-o"></i> View PDF</button></a>
                      <?php
                            echo '<p style="text-align:left;"><b>Draftsman: </b>'.$row['name'].'</p>';
                    ?>
                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Title</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time In</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time Out</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Minutes</th>
                                        </thead>
                                         <tbody>
                                            <?php echo $db -> fetchDailyLogs() ?>
                                        </tbody>
                                        <tfoot>
                                            <?php
                                                $query2 = $dbh->query("SELECT SUM(hrWork) as `consumed` FROM projwork WHERE eID='$did'
                                                                ");
                                                $row2 = $query2->fetch();

                                                $h = floor($row2['consumed'] / 60);
                                                $m = ($row2['consumed'] % 60);
                                                echo '<td colspan = 3 style="text-align:right;"><b>Total:</b></td>';
                                                echo '<td><b>'.$h.' hrs and '.$m.' minutes</b></td>';
                                            ?>
                                        </tfoot>
                                    </table>
                    <a href="draftsmanReport.php"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>
                </fieldset> 



            </form>
        </section><!-- /.content -->
    </body>
</html>



