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
        <script>
            function showSession(str) {
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
                    xmlhttp.open("GET","includes/showSession.php?q="+str,true);
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

                    
                <form id="msform" method="POST">
                        <fieldset>
                            <h1 class="fs-title"><b><span class="glyphicon glyphicon-plus"></span>  Add Skills</b></h1>
                            <?php
                                if(isset($_GET['s'])){
                                    echo '<div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <strong>Success!</strong> Add Skill successful.
                                    </div>';

                                    $null = null;

                                }
                                
                            ?>
                            <label for="skillName" style="float:left;"><i class="fa fa-flag"></i> Skill Name</label>
                            <input name="skillName" class="form-control" placeholder="Enter Skill Name" type="text" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required/>
                        

                            <i class="fa fa-legal"></i><b>Skill Type</b></label><br>
                                <div class="radio">

                                    <!--<input type="hidden" name="type" value=<?php $null?> >
                                    <input type="checkbox"  name="type" value="class" >
                                    Class &nbsp;&nbsp;-->
                                    <select class="form-control" onchange="showSession(this.value)" required>
                                        <option value=""></option>
                                        <option value="skill">Skill</option>
                                        <option value="class">Skill & Class</option>
                                    </select>
                                    
                                    
                                </div>
                            
                            <!--<label for="numberSessions" style="float:left;"><i class="fa fa-clock-o"></i> Number of Sessions</label>
                            <input name="numberSessions" class="form-control" placeholder="eg. 18" type="number"/>-->

                            <div id="contents"></div>
                            <input type="submit" name="save" class="submit action-button" value="Save" required/>
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
        try{
          if(isset($_POST['save'])){
            $skName= $_POST['skillName'];
            $noSess= $_POST['numberSessions'];
            $type= $_POST['type'];
            $stat = 'enabled';

            echo $db-> addSkill($skName,$noSess,$type,$stat);

          }
      }catch(PDOException $e){

      }
        ?>