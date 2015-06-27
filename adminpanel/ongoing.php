<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "List of Ongoing Projects";
            $icon = '<i class="fa fa-tasks"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
                        

            global $dbh;
            $param = $_GET['id'];
            try{
                $query = $dbh -> query("SELECT employeeID as `eid`, firstName as `fn`, lastName as `ln` FROM employee WHERE employeeID='$param'");
                $query -> setFetchMode(PDO::FETCH_ASSOC);
                while($row = $query->fetch()){

            
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
                                    
                                    <h3 class="box-title">&nbsp;<?php echo '<img src="img/users/'.$row['eid'].'.jpg" width="100px" height="100px">'.' '. $row['fn'].' '.$row['ln'];?></h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Title</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-map-marker"></i> Location</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user-md"></i> Owner</th>

                                        </thead>
                                         <tbody>
                                            <?php echo $db -> fetchOngoing(); ?>
                                            
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
    } 
    }catch(PDOException $ex){
                echo $ex->getMessage();
            }
?>