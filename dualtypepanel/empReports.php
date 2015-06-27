<?php
    include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID'];
     $icon = '<i class="fa fa-dashboard"></i>';
     $title = "Reports";
 
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Draftsman | My Reports</title>
        <?php include_once ("includes/head.php"); ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php include_once ("includes/navigation.php"); ?>
            <class="right-side">
                <section class="content">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <span class="glyphicon glyphicon-list"></span>
                                    <h3 class="box-title">&nbsp;List Of My Projects</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                 <table class="table table-bordered">
                                <thead>
                                        <tr role="row">
                                            <th colspan="1" rowspan="1"><i class="fa fa-bars"></i> Project ID</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Name</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Client Name</th> 
                                            <th colspan="1" rowspan="1"><i class="fa fa-phone-square"></i> Contact Number</th>
                                            <th colspan="1" rowspan="1"><i class="fa fa-map-marker"></i> Location</th>
                                            <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Start Date</th>
                                            <th colspan="1" rowspan="1"><i class="fa fa-calendar"></i> Due Date</th>
                                    </thead>
                                <tbody>
                                            <?php echo $db -> fetchListOfmyProjects($id); ?>
                                </tbody>
                                </table>
                   
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                    </div><!-- /.row -->

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <span class="glyphicon glyphicon-list"></span>
                                    <h3 class="box-title">&nbsp;List Of Students</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;" ><i class = "fa fa-male"></i> Student Name</th>
                                                <th style="text-align:center;" ><i class = "fa fa-book"></i> Class</th>
                                                <th style="text-align:center;" ><i class = "fa fa-calendar"></i> Schedule</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            

                                        <tr>
                                            <td><a href="#openModal">Djoven Ballena</a></td>
                                            <td>Adobe Photoshop</td>
                                            <td>7:00 - 8:30 MWF</td>

                                        </tr>
                                        <tr>
                                            <td><a href="#openModal">Jaryd Cariño</a></td>
                                            <td>AutoCad</td>
                                            <td>11:30 - 12:30 MWF</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#openModal">Nazarlie Jimenez</a></td>
                                            <td>Google SketchUp</td>
                                            <td>9:30 - 10:30 TTHS</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#openModal">Joshua Bitancur</a></td>
                                            <td>AutoCad</td>
                                            <td>1:00 - 2:00 MWF</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#openModal">Neil Lacanlale</a></td>
                                            <td>Adobe Photoshop</td>
                                            <td>3:00 - 4:00 TTHS</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#openModal">Jan Eidref Olegario</a></td>
                                            <td>Design Studio Max</td>
                                            <td>4:00 - 5:00 TTHS</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#openModal">Bryan Allen Olegario</a></td>
                                            <td>Vray Rendering Studio</td>
                                            <td>3:00 - 4:00 MWF</td>
                                        </tr>
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

        <div id="openModal" class="modalDialog">
            <div style="text-align:center;">
                <a href="#close" title="Close" class="close">X</a>
                
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="text-align:center;" >Session</th>
                            <th style="text-align:center;" >Date</th>
                            <th style="text-align:center;" >Attendance</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>10-13-14</td>
                            <td><span class="badge bg-green">Present</span></td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>10-15-14</td>
                            <td><span class="badge bg-green">Present</span></td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>10-16-14</td>
                            <td><span class="badge bg-red">Absent</span></td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>10-19-14</td>
                            <td><span class="badge bg-green">Present</span></td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>10-21-14</td>
                            <td><span class="badge bg-green">Present</span></td>
                        </tr>
                    </tbody>

                </table>
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






    </body>
</html>