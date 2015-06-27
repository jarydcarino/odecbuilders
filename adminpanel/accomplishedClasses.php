
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Accomplished Classes";
            $icon = '<i class="fa fa-edit"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";

            $ayo = $_GET['eid'];

            $query2 = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `sname` FROM employee s WHERE s.employeeID='$ayo' ");
            $row2 = $query2->fetch();

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

                    <h2 class="fs-title">Accomplished Classes  </h2>
                    <a href="pdf/classes2.php?eid=<?php echo $_GET['eid']; ?>&type=<?php echo $_GET['type']?>" target="_blank"><button class="btn btn-success btn-sm" type="button"><i class="fa fa-file-o"></i> View PDF</button></a>
                    <table id="example1" class="table table-bordered table-striped">
                        <?php echo '<h4 style="text-align:left;">Tutor: <b>'.$row2['sname'].'</b></h4>';?>
                                        <thead>
                                            <tr role="row">
                                                <th colspan="1" rowspan="1"><i class="fa fa-flag"></i> Class Name</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-user"></i> Student Name</th>
                                                <th colspan="1" rowspan="1"><i class="fa fa-book"></i> Classcard</th>
                                        </thead>
                                         <tbody>
                                            <?php 
                                                $query = $dbh->query("SELECT CONCAT(s.firstName, ' ', s.lastName) as `sname`, skillName as `sn`, t.studID as `sid` 
                                                    FROM student s JOIN tutorial t ON s.studentID = t.studID
                                                    JOIN skills sk ON t.classID = sk.skillID
                                                    WHERE t.status='finished' AND t.empID='$ayo' ");
                                                while($row = $query->fetch()){
                                                    echo '<tr>';
                                                    echo '<td><b>'.$row['sn'].'</b></td>';
                                                    echo '<td><i>'.$row['sname'].'</i></td>';
                                                    echo '<td><a href="classCardFin.php?sid='.$row['sid'].'&eid='.$ayo.'&class='.$row['sn'].'"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-book"></i> View Classcard</button></a></td>';
                                                    echo '</tr>';



                                                }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                    <a href="tutorReport.php"><button type="button" style="width:25%;" name="previous" class="btn btn-success"/>BACK</button></a>
                </fieldset> 



            </form>
        </section><!-- /.content -->
    </body>
</html>



