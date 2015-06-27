<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OLOL Renders Employee | Leave Report</title>

        <?php 
            $title = "Leave Reports";
            $icon = '<i class="fa fa-envelope-o"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
            $nt = $_GET['nt'];

    global $dbh;
    try{
        $query = $dbh->prepare("UPDATE notification SET status='Seen' WHERE notifID=:nt ");
        $query -> bindParam(":nt", $nt);
        $query -> execute();
    }catch (PDOException $e) {
    
    }
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class ="box-title"><i class="fa fa-envelope-o"></i> Leave Report</h3>
                                </div>
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
                                            <tr role="row">
                                                <th><i class="fa fa-envelope-o"></i> Message</th>
                                                <th><i class="fa fa-calendar"></i> Date Range</th>
                                                <th><i class="fa fa-calendar"></i> Date Affirmation</th>
                                                <th><i class="fa fa-flag"></i> Status</th>

                                        </thead>
                                        <tbody>
                                           <?php echo $db -> fetchLeaveReport($id) ?>
                                            
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

<?php
    if(isset($_GET['id'])){
        $lid = $_GET['id'];
        echo $db ->deleteLeaves($lid);
    }    
?>


    </body>
</html>