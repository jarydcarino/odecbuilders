<!DOCTYPE html>

<?php 
    include_once "includes/database.php";
    echo $db -> ifLogin();
     $id = $_SESSION['empID'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Draftsman | Project</title>
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

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <i class="fa fa-th"></i> Project
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Project</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                    <div class="col-md-6">
                            <div class="box box-primary">
                                
                                <div class="box-header">
                                    <h3 class="box-title"><i class="fa fa-th"></i> My Projects</h3>
                                </div>

                                <form>
                                    <div class="box-body">
                                        

                                        <div class="form-group">
                                            <label>Project Name:</label>
                                            <select class="form-control">
                                                <option>Bungalow Residence</option>
                                                <option>Dulay Residence</option>
                                                <option>Gamboa Residence</option>
                                            </select><br>
                                            <label>Project Owner: </label> Rodgers, Rey<br>
                                            <label>Location: </label> Loakan, Baguio City
                                        </div>

                                        <div class="box-footer">
                                            <a class="btn btn-app"><i class="fa fa-play" style="width:215px;"><br>Start</i></a>
                                            <a class="btn btn-app"><i class="fa fa-pause" style="width:215px;"><br>Stop</i></a>
                                        </div>

                                        <div style="margin-left:80px;">
                                            <label style="margin-left:140px;">TIMER</label><br>
                                            <button type="submit" class="btn btn-block" style="height:100px; width:350px; font-size:24px;">20:00:00</button>
                                        </div>     
                                      
                                    </div>
                                </form>


                            </div><!--primary-->
                        </div>


                        <div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header">
                                    <i class="fa fa-bullhorn"></i>
                                    <h3 class="box-title">Project Details</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="callout callout-danger">
                                        <h4>TOTAL NO. OF HOURS</h4>
                                        <b>20 Hours</b>
                                    </div>
                                    <div class="callout callout-info">
                                        <h4>START DATE</h4>
                                        <b>11/15/2014</b>
                                    </div>
                                    <div class="callout callout-warning">
                                        <h4>DUE DATE</h4>
                                        <b>12/01/2014</b>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
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