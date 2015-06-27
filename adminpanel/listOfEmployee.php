<!DOCTYPE html>
<html>
    <head>
        <?php
            $title = "List Of Employees";
            $icon = '<i class="fa fa-users"></i>';
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
                                    <h3 class="box-title"><i class="fa fa-users"></i> List of Employees</h3>
                                </div><!-- /.box-header -->
                                <div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> You have deleted an employee.
                                </div>

                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                              
                                                <th><i class="fa fa-camera-retro" style="width:50px;"></i></th>
                                                <th><i class="fa fa-user"></i> Name</th>
                                                
                                                <th><i class="fa fa-wrench"></i> Type of Employee</th>
                                                <th style="width:300px;"><i class="fa fa-legal"></i> Skills</th>
                                                <th style="width:250px;"><i class="fa fa-pencil"></i> Manage</th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                           <?php echo $db -> fetchEmployees() ?>
                                            
                                        </tbody>
                                            
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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

        

       

    </body>
</html>

<?php
    if(isset($_GET['id'])){
        $pid = $_GET['id'];
        echo $db ->deleteEmployee($pid,$id);
    }
?>