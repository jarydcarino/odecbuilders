<?php 
    include_once "includes/database.php";
    echo $db -> ifLogin();
            $id = $_SESSION['empID'];

?>



<!DOCTYPE html>
<html>
    <head>
        <?php 
            $icon = '<i class="fa fa-user"></i>';
            $title = "View Profile";
            include_once "includes/head.php";
           

            global $dbh;

            try {
                $query = $dbh -> prepare("SELECT CONCAT(firstName,' ',lastName) as `name`, contactNum as `c`, email as `e`, address as `a`, bday as `b`, picture as  `p` FROM employee WHERE employeeID = :empid");
                $query -> bindParam(":empid", $id);
                $query -> execute();

                $row = $query->fetch();
                    $name = $row['name'];
                    $contact = $row['c'];
                    $add = $row['a'];
                    $eadd = $row['e'];
                    $pic = $row['p'];
                    $d = $row['b'];

                    $birth = date("F d, Y",strtotime($d));

                $query4 = $dbh -> prepare("SELECT username, password, type FROM account WHERE empID = :empid");
                $query4 -> bindParam(":empid", $id);
                $query4 -> execute();

                $row4 = $query4->fetch();
                    $user = $row4['username'];
                    $password = $row4['password'];
                    $type = $row4['type'];
                
                


                
                   
            
                



        ?>

        <link type="text/css" rel="stylesheet" href="css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700|Lato:400,300' rel='stylesheet' type='text/css'>

    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php"; ?>

                <!-- Main content -->
                <section class="content">

                <div class="row">
                    
               

                    <form id="msform" method="POST" style="width:80%; ">
                        <ul id="progressbar">
                            <li class="active">Personal Details</li>
                            <li style="margin-left:50%;">Available Schedule</li>
                        </ul>

                        <fieldset style="margin-bottom:50px;">

                            <div id="cv" class="instaFade">
                            <div class="mainDetails">
                                <div id="headshot" class="quickFade">
                                    <img src="<?php echo $pic?>"/>
                                </div>
                                
                                <div id="name">
                                    <h1 class="quickFade delayTwo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name;?></h1>
                                    <h2 class="quickFade delayThree">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $type;?></h2>
                                </div>
                                
                                
                                <div class="clear"></div>
                            </div>
                            
                            <div id="mainArea" class="quickFade delayFive">
                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Address</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $add;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>
                                
                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Email Address</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $eadd;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>

                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Contact Number</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $contact;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>

                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Birthdate</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $birth;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>

                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Username</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php echo $user;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>
                                
                                <section>
                                    <article>
                                        <div class="sectionTitle">
                                            <h1>Password</h1>
                                        </div>
                                        
                                        <div class="sectionContent">
                                            <h2>&nbsp;&nbsp;<?php $hidden_password = preg_replace("|.|","*",$password); echo $hidden_password;?></h2>
                                        </div>
                                    </article>
                                    <div class="clear"></div>
                                </section>

                                <section>
                                    <div class="sectionTitle">
                                        <h1>Key Skills</h1>
                                    </div>
                                    
                                    <div class="sectionContent">
                                        
                                         <?php 

                                        $query2 = $dbh->query("SELECT se.empID as `empid`, se.skillID as `skillid`, GROUP_CONCAT(s.skillName, ' ') as `sn` FROM skillemp se JOIN skills s ON se.skillID=s.skillID WHERE empID= '$id';
                                                            ");
                                        $query2 -> setFetchMode(PDO::FETCH_ASSOC);
                                        while($row2 = $query2->fetch()){
                                            $skill = $row2['sn'];

                                            echo '<h2>'.$skill.'<h2>';
                                        }

                                        ?>
                                            
                                        
                                    </div>

                                    <div class="clear"></div>
                                </section>
                                
                            </div>
                        </div>
                            <input type="button" name="next" class="next action-button" value="Next" /><br>

                        </fieldset>
                        
                    <!-- progressbar -->
                        

                   
               

                <fieldset style="margin-bottom:50px;">

                    <h2 class="fs-title">Available Schedule</h2>

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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '9:00 - 10:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '10:00 - 11:00 AM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '11:00 - 12:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '12:00 - 1:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '1:00 - 2:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '2:00 - 3:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '3:00 - 4:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '4:00 - 5:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                            <td>5:00 - 6:00 PM</td>
                            <?php
                                global $dbh;


                                try{
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '5:00 - 6:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '6:00 - 7:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                                    $query = $dbh->query("SELECT day, time, availability, studID as `sid`, classID as `cid`, classsched FROM schedule s JOIN employee e ON e.employeeID = s.employeeID WHERE s.employeeID = '$id'");
                                    $query -> setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()){
                                        $day = $row['day'];
                                        $time = $row['time'];
                                        $av = $row['availability'];
                                        $studID = $row['sid'];
                                        $classID = $row['cid'];
                                        $status = $row['classsched'];

                                        $query2 = $dbh->prepare("SELECT s.studID, s.classID, s.classsched, CONCAT(st.firstName,' ',st.lastName) as `name`, sk.skillName as `class` FROM schedule s 
                                            JOIN employee e ON e.employeeID = s.employeeID 
                                            JOIN student st ON st.studentID = s.studID
                                            JOIN skills sk ON sk.skillID = s.classID
                                            WHERE s.employeeID = '$id' AND s.studID = '$studID'");
                                        $query2 -> execute();
                                        $row2 = $query2->fetch(PDO::FETCH_ASSOC);
                                        

                                            $student = $row2['name'];
                                            $className = $row2['class'];
                                            $cs = $row2['classsched'];
                                           


                                            
                                              
                                                if($time == '7:00 - 8:00 PM'){
                                                    if($day == 'Monday'){
                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }
                                                    }else if($day == 'Tuesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Wednesday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Thursday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Friday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Saturday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
                                                            echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                                                        }else if($av == '0'){
                                                            echo '<td></td>';
                                                        }

                                                    }else if($day == 'Sunday'){

                                                        if($av == '1' && $status == '1' && $cs =='1'){
                                                            echo '<td><b>'.$student.'</b><br><i>('.$className.')</i></td>';
                                                        }else if($av == '1'){
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
                    <input type="button" name="previous" class="previous action-button" value="Previous" /><br>
                    

                </fieldset> 

                 </form>
                </div><!-- /.row -->

                </section><!-- /.content -->

        <!-- add new calendar event modal -->

    </body>
</html>

<?php
            
                
                
            } catch (PDOException $e) {
                echo $e->getMessage();
                die();
                
            } 

        
        
    ?>
