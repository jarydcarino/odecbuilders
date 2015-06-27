<?php
   
    include_once("includes/database.php");
    echo $db -> ifLogin();
    $id = $_SESSION['empID'];


?>

<!DOCTYPE html>
<html>
    <head>
      <?php 
        $title = "Notification";
        $icon = '<i class="fa fa-globe"></i>';
        include_once "includes/head.php";
        $eid = $_GET['id'];
      ?>
    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php" ?>

                <!-- Main content -->
                <section class="content">

                    
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Your Notification</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <?php
                                        echo '<tr><th style="margin-right:100px;">Notifications</th><th>Status</th></tr>';
                                            $query = $dbh->query("SELECT CONCAT(e.firstName, ' ', e.lastName) as 'name', e.firstName as `fn`, e.lastName as `ln`, sender, reciever, msg, link, notifID as `nt`, status FROM notification n
                                            JOIN employee e ON n.sender=e.employeeID WHERE reciever='$eid' ORDER BY nt DESC LIMIT 50");
                                            while($row = $query->fetch()){
                                                if($row['fn'] == $row['ln']){
                                                    
                                                    echo '<tr>
                                                    <td><i class="fa fa-globe" style="margin-right:10px;"></i> <a href='.$row['link'].'?nt='.$row['nt'].'>'.$row['fn'].' '.$row['msg'].'</a></td>';
                                                    if($row['status'] == "Seen"){
                                                        echo'<td><span class="label label-success">'.$row['status'].'</span></td>';
                                                    }else{
                                                        echo'<td><span class="label label-danger">'.$row['status'].'</span></td>';
                                                    }
                                                    
                                                    echo '</<tr>';
                                                }else{
                                                    echo '<tr>
                                                    <td><i class="fa fa-globe" style="margin-right:10px;"></i> <a href='.$row['link'].'?nt='.$row['nt'].'>'.$row['name'].' '.$row['msg'].'</a></td>';
                                                    if($row['status'] == "Seen"){
                                                        echo'<td><span class="label label-success">'.$row['status'].'</span></td>';
                                                    }else{
                                                        echo'<td><span class="label label-danger">'.$row['status'].'</span></td>';
                                                    }
                                                    echo '</<tr>';
                                                }
                                                
                                            }
                                        ?>
                                        
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        
                        

                        

                    </div>

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

        <!-- fullCalendar -->
        <script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>


    </body>
</html>