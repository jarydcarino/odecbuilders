
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Ongoing Project";
            $icon = '<i class="fa fa-edit"></i>';
            $id = $_GET['id'];
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
        ?>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php include_once "includes/navigation.php" ?>

                <!-- Main content -->
        <section class="content">
            <form id="msform" method="POST" style="width:80%; ">
            <!-- progressbar -->
                
                <!-- fieldsets -->

                <fieldset>

                    <h2 class="fs-title">Ongoing Project</h2>
                     <a href="pdf/projects.php?id=<?php echo $_GET['id']; ?>&stat=<?php echo $_GET['stat'];?>" target="_blank"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-file-o"></i> View PDF</button></a>
                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Project Title</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Owner</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-legal"></i> Skill</th>
                                                <th colspan="1" rowspan="1"><span class="glyphicon glyphicon-stats"></span> Logs</th>
                                        </thead>
                                         <tbody>
                                            <?php echo $db -> fetchOngoingProjects2() ?>
                                            
                                        </tbody>
                                    </table>
                    <a href="draftsmanReport.php"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>
                </fieldset> 



            </form>
        </section><!-- /.content -->
    </body>
</html>



