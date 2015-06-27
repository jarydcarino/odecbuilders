
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Schedule";
            $icon = '<i class="fa fa-calendar"></i>';
            include_once "includes/database.php";
             echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";

            $did = $_GET['id'];
                       

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

                <fieldset style="margin-bottom:50px;">

                    <h2 class="fs-title">Available Schedule</h2>
                    <?php 
                        $query = $dbh->query("SELECT CONCAT(firstName, ' ', lastName) as `name` FROM employee WHERE employeeID='$did'; ");
                        while($row=$query->fetch()){
                            echo '<p style="float:left;">NAME: <b>'.$row['name'].'</b></p>';
                        }
                    ?>
                    <?php
                        global $dbh;

                        try{

                            $query = $dbh->query("SELECT COUNT(availability) as `availabletime` FROM schedule s WHERE s.employeeID = '$did' AND availability = '1' AND studID is null");
                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                            while($row = $query->fetch()){
                                echo '<h3><font color="blue">Available Time per Week: '.$row['availabletime'].'</font></h3>';

                            }


                        }catch(PDOException $ex){
                            echo $ex->getMessage();
                        }
                    ?>
                    <table class="table table-striped" style="text-align:center;">
                        <tr>
                            <th style="text-align:center;">TIME</th>
                            <th style="text-align:center;">Monday</th>
                            <th style="text-align:center;">Tuesday</th>
                            <th style="text-align:center;">Wednesday</th>
                            <th style="text-align:center;">Thursday</th>
                            <th style="text-align:center;">Friday</th>
                            <th style="text-align:center;">Saturday</th>
                            <th style="text-align:center;">Sunday</th>

                        </tr>
                        <tr>
                            <td>9:00 - 10:00 AM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '9:00 - 10:00 AM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }       
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>10:00 - 11:00 AM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '10:00 - 11:00 AM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }       
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>11:00 - 12:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '11:00 - 12:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }      
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>12:00 - 1:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '12:00 - 1:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }       
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>1:00 - 2:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '1:00 - 2:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }      
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>2:00 - 3:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '2:00 - 3:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }      
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>3:00 - 4:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '3:00 - 4:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }      
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>4:00 - 5:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '4:00 - 5:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }       
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>                        </tr>
                        <tr>
                            <td>5:00 - 6:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '5:00 - 6:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }       
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>6:00 - 7:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '6:00 - 7:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }      
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        <tr>
                            <td>7:00 - 8:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, availabletime FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$did'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];

                                        if($time == '7:00 - 8:00 PM'){
                                            if($day == 'Monday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Tuesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Wednesday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Thursday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Friday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Saturday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }else if($day == 'Sunday'){
                                                if($av == '1'){
                                                    echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                }else if($av == '0'){
                                                    echo '<td></td>';
                                                }
                                            }      
                                        }                                  

                                    }


                                }catch(PDOException $ex){
                                    echo $ex->getMessage();
                                }

                            ?>
                        </tr>
                        
                        

                    </table>
                    <a href="listDraftsman.php"><button type="button" style="width:25%;" name="previous" class="btn btn-danger"/>BACK</button></a>
                </fieldset> 



            </form>
        </section><!-- /.content -->
    </body>
</html>



