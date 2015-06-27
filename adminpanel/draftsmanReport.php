<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OLOL Renders Admin | Draftsman Report</title>
        <?php 
            $title = "Draftsman Report";
            $icon = '<i class="fa fa-bar-chart-o"></i>';
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
                <!-- Main content -->
                <section class="content">  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class ="box-title"><i class="fa fa-bar-chart-o"></i> Draftsman Report &nbsp; <a href="pdf/draftsman_report.php" target="_blank"><button class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> View PDF</button></a></h3>
                                </div>                                
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-camera-retro"></i></th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Name</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-check"></i> No. of Accomplished Projects</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-spinner"></i> No. of Ongoing Projects</th>
                                        </thead>
                                        <tbody>
                                           <?php echo $db -> fetchDraftsmanReport() ?>
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
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- add new calendar event modal -->
    </body>
</html>