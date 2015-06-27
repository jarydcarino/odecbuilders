<!DOCTYPE html>
<?php
    //session_start();
?>
<html>
    <head>
        <?php 
            $title = "Assign Student";
            $icon = '<i class="fa fa-male"></i>';
            include_once "includes/database.php";
            echo $db -> ifLogin();
            $id = $_SESSION['empID'];
            include_once "includes/head.php";
        ?>
        <script>
            function showSchedule(str) {
                if (str == "") {
                    document.getElementById("contents").innerHTML = "";
                    return;
                } else { 
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("contents").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","includes/showSchedule.php?q="+str,true);
                    xmlhttp.send();
                }
            }

            function showTutor(str) {
                if (str == "") {
                    document.getElementById("content").innerHTML = "";
                    return;
                } else { 
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("content").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","includes/showTutor.php?q="+str,true);
                    xmlhttp.send();
                }

            }

            /*function hideModal(e){
                $(".modalDialog").hide();
                e.preventDefault();
            }*/
        </script>
    </head>
    <body class="skin-blue">
        <?php include_once "includes/navigation.php" ?>
                <!-- Main content -->
                <section class="content">
                    <form id="msform" method="POST" onsubmit="return validate_form();">
                    <!-- progressbar -->

                        <fieldset style="margin-bottom:50px;">
                            <h3 class="fs-title">Assign Student</h2>
                            <?php
                                if(isset($_GET['s'])){
                                    echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <strong>Success!</strong> The student was assigned to a tutor.
                                    </div>';

                                }
                                
                            ?>
                            <label style="float:left;"><i class="fa fa-user"></i> Student Name</label><br>
                            <input name = "fname" id="firstName" type="text" placeholder="First Name" pattern="[a-zA-Z]+[a-zA-Z ]+" required/> 
                            <input name="lname" id="lastName" type="text" placeholder="Last Name" pattern="[a-zA-Z]+[a-zA-Z ]+" required>
                        
                            <label for="email" style="float:left;"><i class="fa fa-envelope"></i> Email</label>
                            <input name="email" id="email" type="email" placeholder="eg. olol@gmail.com" required/>

                            <label for="contactNumber" style="float:left;"><i class="fa fa-mobile-phone"></i> Contact Number</label>
                            <input name="cnumber" id="contactNumber" type="text" placeholder="eg. 0915*******" maxlength="11" pattern="[0-9].{6,}" required>
                            
                            <label style="float:left; display: block;"><i class="fa fa-book"></i> Class Name</label><br><br>

                                <?php 
                                    echo '<select class="form-control" name="classID" required="required" onchange="showTutor(this.value)">';
                                    $query = $dbh->query("SELECT skillName as `sk`, skillID as `sid`, session FROM skills WHERE skillType='class' AND stat='enabled'");
                                    echo '<option ></option>';  
                                    while($row = $query->fetch()){
                                    echo "<option value=".$row['sid'].">&nbsp;&nbsp;".$row['sk']."&nbsp; - &nbsp;".$row['session']." sessions";
                                    }
                                    echo "</select>"; 

                                ?><br>



                                <div id="content"></div>
                                <div id="contents"></div>

                    <input type="submit" name="add" value="Assign" class="submit action-button"/> 
                    <input type="reset" value="Clear" class="submit action-button">
                </fieldset>

                        
                    </form>
                </section><!-- /.content -->

<?php
    global $dbh;
    try{

        if(isset($_POST['add'])){

            $schedule = $_REQUEST['availabletime'];

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $cnumber = $_POST['cnumber'];
            // $classID = $_POST['classID'];
            $tutor = $_POST['tutor'];
            $temp = $_POST['classID'];

            //echo $tutor;

                try{
                    $query2 = $dbh->query("SELECT session as `s` FROM skills 
                               WHERE skillID = '$temp' ");
                     $row2 = $query2 -> fetch();
                     }catch(PDOException $ex){
                                            echo $ex->getMessage();
                                            die();
                                    }

            $session = $row2['s'];
            //$classID = $session[0];
            //$numSession = $session[1];

            echo $db -> assignStudents($fname,$lname,$email,$cnumber,$session,$temp,$tutor,$id);             
            
            foreach ($schedule as $sched){
                list($time,$day,$status) = explode(".", $sched);
               echo $db -> insertStudentSched($tutor,$temp,$day,$time,$status);            
            }
        }
    } catch (PDOException $e) {
    }
?>
</body>
    <script>
    function validate_form()
        {
        valid = true;

        if($('input[type=checkbox]:checked').length < 1)
        {
            alert ( "Please select at least 1 checkbox in the schedule" );
            //document.getElementById('errorFirstNameMissing').style.visibility='visible';
            valid = false;
        }

        return valid;
        }

    </script>
</html>