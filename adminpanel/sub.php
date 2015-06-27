<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Classes" ;
            $icon = '<i class="fa fa-book"></i>';
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
                    <!-- Small boxes (Stat box) -->
                   <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <span class="glyphicon glyphicon-book"></span>
                                    <h3 class="box-title">&nbsp;List Of Classes</h3>
                                </div><!-- /.box-header -->
                                <div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> You have assigned a substitute.
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-book"></i> Class Name</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-male"></i> Student Name</th>
                                                <th colspan="1" rowspan="1" style="width:150px;"><i class="fa fa-calendar"></i> Schedule</th>
                                                <th colspan="1" rowspan="1" style="width:150px;"><i class="fa fa-clock-o"></i> Session</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Tutor</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-gears"></i> Options</th>
                                        </thead>
                                        <tbody>
                                            <?php echo $db -> fetchClasses() ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            </div><!--primary-->
                        </div>
                    </div><!-- /.row -->

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
