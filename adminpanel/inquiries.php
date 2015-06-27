</html>
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Inquiries";
            $icon = '<i class="fa fa-comments-o"></i>';
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
                                    <i class="fa fa-comments-o"></i>
                                    <h3 class="box-title">&nbsp;Inquiries</h3>                                   
                                </div><!-- /.box-header -->
                                    
                                    <?php
                                        if(isset($_GET['s'])){
                                        $s = $_GET['s'];
                                        if($s=="deleted"){
                                            echo '<div class="alert alert-danger" id="alert" style="visibility: true; display: block; width:90%;">
                                                <a href="#" class="close" data-dismiss="alert">×</a>
                                                <strong>Inquiries Deleted!</strong>
                                            </div>' ;
                                            }elseif($s=="delete"){
                                                 echo '<div class="alert alert-danger" id="alert" style="visibility: true; display: block; width:90%;">
                                                <a href="#" class="close" data-dismiss="alert">×</a>
                                                <strong>Inquiry Deleted!</strong>
                                            </div>' ;
                                            }
                                        }
                                    ?>

                                <div class="box-body table-responsive">
                                    <form method="POST">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                              
                                                <th><i class="fa fa-envelope-o"></i> Message</th>
                                                <th><i class="fa fa-envelope"></i> Email</th>
                                                <th><i class="fa fa-calendar"></i> Date</th>


                                            </tr>
                                        </thead>
   
                                         <tbody>
                                            
                                            <?php echo $db -> fetchInquiries() ?>
                                            
                                        </tbody>
                                       <input type="submit" name="del" value="DELETE" class="btn btn-default btn-md"/>
                                        <br><br>
                                    </table>

                                    </form>


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
    if(isset($_GET['id'])){
        $inqid = $_GET['id'];
        echo $db ->deleteInquiry($inqid);
    }

    if(isset($_POST['del'])){
        $del = $_POST['message'];

                $query = $dbh->prepare("DELETE FROM inquiries WHERE inqid=:id");
                foreach($del as $did){
                    $query->execute(array(':id' => $did));
                }

               echo "<script>window.location='inquiries.php?s=deleted'</script>";
    }    
?>