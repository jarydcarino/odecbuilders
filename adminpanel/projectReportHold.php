<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OLOL Renders Admin | Project Report</title>

        <?php 
            $title = "Project Report";
            $icon = '<i class="fa fa-clipboard"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
                        
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
                                <a href="projectReportOngoing.php" class="small-box-footer">
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
                                <a href="projectReportFinished.php" class="small-box-footer">
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
                                <a href="projectReportHold.php" class="small-box-footer">
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
                                <a href="projectReportCancelled.php" class="small-box-footer">
                                    View Table <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class ="box-title"><i class="fa fa-clipboard"></i> Onhold Projects <a href="pdf/proj_reports_hold.php" target="_blank"><button class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a></h3>
                                </div>
                                    <div class="box-body table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Title</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Draftsman</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-legal"></i> Skill</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-map-marker"></i> Location</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Due Date</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time Left</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time Consumed</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Owner</th>
                                                <th colspan="1" rowspan="1"><span class="glyphicon glyphicon-stats"></span> Logs</th>
                                                
                                        </thead>
                                        <tbody>
                                           <?php echo $db -> fetchProjectReportHold() ?>
                                            
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