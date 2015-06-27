<?php
    include_once "includes/database.php";
     echo $db -> ifLogin();
     $id = $_SESSION['empID']; 
     $tid = $_GET['tid'];


     $query = $dbh->query("SELECT
                                    CONCAT(s.firstName,' ', s.lastName) as `name`, s.studentID as `sid`,
                                    s.classID as `cn`, sk.skillName as `sn`, GROUP_CONCAT(DISTINCT '  ',ss.day, ' ') as `schedule`, GROUP_CONCAT(DISTINCT '  ',ss.time, ' ') as `time`,
                                    ss.classsched as `status`, s.instid as `inst`, sk.skillID as `cid`, t.tutorialID as `tid`, s.session,e.employeeID as `eid`,
                                    CONCAT(e.firstName,' ', e.lastName) as `tutor`,
                                    s.email as `email`, s.session, s.contact as `contact`
                                    FROM student s
                                    JOIN employee e ON e.employeeID = s.instID
                                    JOIN schedule ss ON ss.studID = s.studentID
                                    JOIN skills sk ON s.classID = sk.skillID
                                    JOIN tutorial t ON t.studID = s.studentID
                                    WHERE ss.classsched = '1' AND t.empID = '$id' AND t.tutorialID ='$tid';
                                    GROUP BY t.studID;
                                    ");
            $row = $query->fetch();
            $tutor=$row['tutor'];
            $day = $row['schedule'];
            $time = $row['time'];
?>



<!DOCTYPE html>
<html>
    <head>

       <?php
            $icon = '<i class="fa fa-print"></i>'; 
            $title = "Reports";
            include_once "includes/head.php" ;
        ?>

    </head>
    <body class="skin-blue">
       
                <?php include_once "includes/navigation.php" ?>
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->

                    <form id="msform" method="POST">
                    <!-- progressbar -->

                        <!-- fieldsets -->
                        <fieldset>
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-list-alt"></span>  CLASS CARD</b></h1>
                            <p style="text-align:left;"><b>Class Name: </b>&nbsp;<?php echo $_GET['class']?></p>
                            <p style="text-align:left;"><b>Student Name: </b> &nbsp;<?php echo $_GET['name']?></p>
                            <p style="text-align:left;"><b>Instructor:</b> <?php echo $tutor; ?></p>
                            <p style="text-align:left;"><b>Day:</b> <?php echo $day; ?></p>
                            <p style="text-align:left;"><b>Time:</b> <?php echo $time; ?></p>
                            

                            <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                       
                                                <th colspan="1" rowspan="1" style="text-align:center;"><i class="fa fa-calendar"></i> Date</th>
                                                <th colspan="1" rowspan="1" style="text-align:center;"><i class="fa fa-male"></i> Instructor / Substitute</th>
                                                <th colspan="1" rowspan="1" style="text-align:center;"><i class="glyphicon glyphicon-list-alt"></i> Attendance</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                            $query = $dbh->query("SELECT `date`, attendance,
                                                CONCAT(e.firstName, ' ', e.lastName) as `name` 
                                                FROM class c 
                                                JOIN employee e ON c.instID = e.employeeID
                                                WHERE tutorialID='$tid' ");
                                            while($row = $query->fetch()){
                                                $date = date("F d, Y",strtotime($row['date']));
                                                echo '<tr>';
                                                echo '<td>'.$date.'</td>';
                                                echo '<td>'.$row['name'].'</td>';

                                                if($row['attendance'] == 'Present'){
                                                    echo '<td><span  class="label label-success">'.$row['attendance'].'</span></td>';
                                                }else if($row['attendance'] == 'Absent'){
                                                    echo '<td><span  class="label label-danger">'.$row['attendance'].'</span></td>';
                                                }
                                               
                                                echo '</tr>';

                                            }
                                        ?>
                                        
                                       </tbody>
                                    </table>
                                

                            <a href="tutClasses.php"><input type="button" name="next" class="next action-button" value="Back" required/></a>
                        </fieldset>

                        


                    </form>


                    <!-- Main row -->
                    
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->



       

    </body>
</html>