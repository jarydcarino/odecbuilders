<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "List of Projects";
            $icon = '<i class="fa fa-briefcase"></i>';
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
                                    <span class="glyphicon glyphicon-list"></span>
                                    <h3 class="box-title">&nbsp;List Of Ongoing Projects</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <strong>Success!</strong> The project is finished.
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Title</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-pencil"></i> Draftsman</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-legal"></i> Skill</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Due Date</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-clock-o"></i> Time Left</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-thumb-tack"></i> Status</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-gears"></i> Options</th>

                                        </thead>
                                         <tbody>
                                            <?php echo $db -> fetchProjects() ?>
                                            
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