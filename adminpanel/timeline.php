<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Timeline" ;
            $icon = '<i class="fa fa-clock-o"></i>';
            
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


                    <!-- row -->
                    <div class="row">                        
                        <div class="col-md-12">
                            <!-- The time line -->
                            <ul class="timeline">
                                <?php
                                        if(isset($_GET['s'])){
                                            echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                <strong>Success!</strong> You have cleared the timeline.
                                            </div>';

                                        }

                                        
                                        
                                    ?>
                                <?php
                                    try {
                                        $query = $dbh -> query("SELECT * FROM timeline");
                                        if ($query->rowCount() > 0) {
                                            echo '<a href="includes/clear.php"><button class="btn btn-default" style="margin-left:90%;" name="clear" type="submit"><i class="fa fa-fw fa-trash-o" style="text-align:center;"></i> Clear All</button></a>';
                                        }else{
                                            echo '<a href="includes/clear.php"><button class="btn btn-default" style="margin-left:90%;" name="clear" type="submit" disabled><i class="fa fa-fw fa-trash-o" style="text-align:center;"></i> Clear All</button></a>';
                                        }
                                    } catch (PDOException $ex) {
                                        echo $ex -> getMessage();
                                    }
                                
                                ?>
                                <?php echo $db -> timeline() ?>
                                <!-- END timeline item -->
                                
                                <li>
                                    <i class="fa fa-clock-o"></i>
                                </li>
                            </ul>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->




    </body>
</html>
