<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "List of Tutors"; 
            $icon = '<i class="fa fa-user"></i>';
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
                                    <h3 class ="box-title"><i class="fa fa-user"></i> List of Tutors</h3>
                                </div>
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                            <th colspan="1" rowspan="1" style="width:50px;"><i class="fa fa-camera-retro"></i></th>
                                            <th colspan="1" rowspan="1" style="width:150px;"><i class="fa fa-user"></i> Tutor</th>
                                            <th colspan="1" rowspan="1"><i class="fa fa-book"></i> Classes</th>
                                            <th colspan="1" rowspan="1" style="width:150px;"><i class="fa fa-calendar"></i> Schedule</th>
                                        </thead>
                                        <tbody>
                                            <?php echo $db -> fetchTutors() ?>
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