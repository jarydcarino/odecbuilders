</html>
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Requests";
            $icon = '<span class="glyphicon glyphicon-comment"></span>';
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
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        Accepted
                                    </h3>
                                    <p>
                                        Leave Request
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                                <a href="leaveReportsAccepted.php" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        Declined
                                    </h3>
                                    <p>
                                        Leave Requests
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-flag"></i>
                                </div>
                                <a href="leaveReportsDeclined.php" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <span class="glyphicon glyphicon-comment"></span>
                                    <h3 class="box-title">&nbsp;Requests for Leave</h3>                                   
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">

                                    <?php
                                if(isset($_GET['s'])){
                                    echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <strong>Success!</strong> The leave message is deleted.
                                    </div>';

                                }
                                
                            ?>

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                
                                                <th><i class="fa fa-envelope-o"></i> Message</th>
                                                <th><i class="fa fa-user"></i> Employee Name</th>
                                                <th><i class="fa fa-calendar"></i> Date Range</th>
                                                <th><i class="fa fa-calendar"></i> Date Affirmation</th>
                                                <th><i class="fa fa-flag"></i> Status</th>
                                        </thead>
                                         <tbody>
                                            <?php echo $db -> leaveReports() ?>
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
    if(isset($_GET['id'])){
        $lid = $_GET['id'];
        echo $db ->deleteLeaves($lid);
    }    
?>