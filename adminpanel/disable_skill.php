<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OLOL Renders Admin | Content Management</title>
        <?php 
            $title = "Content Management";
            $icon = '<i class="fa fa-edit"></i>';
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

                    
                <form id="msform" method="POST">
                        <fieldset>
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-minus"></span>  Disable Skill</b></h1>
                            <?php
                                if(isset($_GET['s'])){
                                    echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <strong>Success!</strong> Skill has been disabled.
                                    </div>';

                                    $null = null;

                                }
                                
                            ?>
                            <select required class="form-control" name="skill" style="width:100%;">
                                <option value=""></option>
                            <?php 
                                $query = $dbh->query("SELECT skillID as `sid`, skillName as `sn` FROM skills WHERE stat='enabled'");
                                while($row = $query->fetch()){
                                    echo '<option value="'.$row['sid'].'">'.$row['sn'].'</option>';
                                }
                            ?>

                            
                            </select>
                            <br>
                            <button type="submit" class="btn btn-danger btn-lg" name="disable">DISABLE</button>
                        </fieldset>
                    </form>
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

<?php 
    if(isset($_POST['disable'])){
        $skill = $_POST['skill'];
        $stat = 'disabled';
        $query = $dbh->prepare("UPDATE `skills` SET stat=? WHERE skillID=?");
        $query -> bindParam(1,$stat);
        $query -> bindParam(2,$skill);
        $query -> execute();

        echo '<script>window.location="disable_skill.php?s=success";</script>';
    }
?>

    