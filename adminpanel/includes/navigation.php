<?php
    include_once "includes/database.php";
    global $dbh;
    $eid = $_SESSION['empID'];
         $query = $dbh -> prepare("SELECT firstName as 'f', lastName as 'l', picture as 'p' FROM employee WHERE employeeID = :empid");
         $query -> bindParam(":empid",$id);
         $query -> execute();
         while($row = $query->fetch()){
            $img = $row['p'];


?>


        <!-- header logo: style can be found in header.less -->
        <header class="header">

            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="img/logo.png" alt="logo" class="logo">
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right" id="refresh">
                    <ul class="nav navbar-nav">
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-globe"></i>
                                
                                        <?php echo $db -> fetchnotif($id); ?> 
                                    </ul>
                                </li>
                                <li class="footer"><a href='notifView.php?id=<?php echo $eid;?>'>View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $row['f'];?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo $img;?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $row['f'].' '.$row['l']?>
                                        <small>OLOL Administrator</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div style="text-align:center;">

                                        <a href="../logout.php" class="btn btn-warning btn-sm" style=" font-size:15px; width:60%;"><span class="glyphicon glyphicon-off"></span></a>
                                        <a href="viewAdminProfile.php" class="btn btn-default btn-sm"><i class="fa fa-user"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo $img; ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $row['f'];?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="index.php">
                                <i class="fa fa-home"></i> <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="timeline.php">
                                <i class="fa fa-clock-o"></i> <span>Timeline</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <span class="glyphicon glyphicon-briefcase"></span>
                                <span>Project</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                            global $dbh;
                                            try{
                                                $query = $dbh->query("SELECT projectID, COUNT(*) as `status`
                                                                    FROM project
                                                                    WHERE status = 'hold' OR status = 'ongoing' AND draftsmanID is not null");
                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                            while($row = $query->fetch()){
                                                $o = $row['status'];
                                            }
                                            }catch(PDOException $ex){
                                                echo $ex->getMessage();
                                            }
                                if($o == 0){
                                    echo '<li><a href="listProjects.php"><i class="fa fa-angle-double-right"></i> List of Projects</a></li>';
                                }else{        
                                    echo '<li><a href="listProjects.php"><i class="fa fa-angle-double-right"></i> List of Projects<small class="badge pull-right bg-yellow">'.$o.'</small></a></li>';
                                }
                                ?>
                                <li><a href="listDraftsman.php"><i class="fa fa-angle-double-right"></i> List of Draftsman</a></li>
                                <li><a href="addProject.php"><i class="fa fa-angle-double-right"></i> Add Project</a></li>
                                <?php
                                            global $dbh;
                                            try{
                                                $query = $dbh->query("SELECT projectId, COUNT(*) as `status`
                                                                    FROM project
                                                                    WHERE status = 'ongoing' AND draftsmanID is null");
                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                            while($row = $query->fetch()){
                                                $o = $row['status'];
                                            }
                                            }catch(PDOException $ex){
                                                echo $ex->getMessage();
                                            }
                                if($o == 0){
                                    echo '<li><a href="assignDraftsman.php"><i class="fa fa-angle-double-right"></i> Assign Draftsman</a></li>';
                                }else{
                                echo '<li><a href="assignDraftsman.php"><i class="fa fa-angle-double-right"></i> Assign Draftsman<small class="badge pull-right bg-blue">'.$o.'</small></a></li>';
                                }
                                ?>
                            </ul>
                        </li>
<!--                         <li class="treeview">
                            <a href="#">
                                <span class="glyphicon glyphicon-book"></span>
                                <span>Tutorials</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="listOfClasses.php"><i class="fa fa-angle-double-right"></i> List of Classes</a></li>
                                <li><a href="listOfTutors.php"><i class="fa fa-angle-double-right"></i> List of Tutors</a></li>
                                <li><a href="assignStudents.php"><i class="fa fa-angle-double-right"></i> Assign Students</a></li>
                                <!--<li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>-->
<!--                             </ul>
                        </li>  -->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Employees</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="addEmployee.php?"><i class="fa fa-angle-double-right"></i> Add Employee</a></li>
                                 <li><a href="listOfEmployees.php"><i class="fa fa-angle-double-right"></i> List of Employees</a></li>
                                <!--<li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>-->
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-print"></i>
                                <span>Reports</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="draftsmanReport.php"><i class="fa fa-angle-double-right"></i> Draftsman Report</a></li>
                               <!--  <li><a href="tutorReport.php"><i class="fa fa-angle-double-right"></i> Tutor Report</a></li> -->
                                <li><a href="projectReport.php?type=all"><i class="fa fa-angle-double-right"></i> Project Report</a></li>
                               <!--  <li><a href="classReport.php?type=all"><i class="fa fa-angle-double-right"></i> Class Report</a></li> -->
                                <!--<li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                                <li><a href="pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                                <li><a href="pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>-->
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <span class="glyphicon glyphicon-comment"></span>
                                <span>Requests</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <?php
                                            global $dbh;
                                            try{
                                                $query = $dbh->query("SELECT COUNT(*) as `number`
                                                                    FROM leaves WHERE affirmation='0'
                                                                    ");
                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                            while($row = $query->fetch()){
                                                $r = $row['number'];
                                            }
                                            }catch(PDOException $ex){
                                                echo $ex->getMessage();
                                            }
                                 if($r == 0){
                                    echo '<li><a href="requests.php"><i class="fa fa-angle-double-right"></i> Leave Requests</a></li>';
                                 }else{

                                echo '<li><a href="requests.php"><i class="fa fa-angle-double-right"></i> Leave Requests<small class="badge pull-right bg-red">'.$r.'</small></a></li>';
                                }
                                ?>
                                <li><a href="leaveReports.php"><i class="fa fa-angle-double-right"></i> Leave Reports</a></li>
                            </ul>

                        </li>
                        <li>
                            <?php
                                            global $dbh;
                                            try{
                                                $query = $dbh->query("SELECT COUNT(*) as `number`
                                                                    FROM inquiries
                                                                    ");
                                            $query -> setFetchMode(PDO::FETCH_ASSOC);
                                            while($row = $query->fetch()){
                                                $i = $row['number'];
                                            }
                                            }catch(PDOException $ex){
                                                echo $ex->getMessage();
                                            }
                            if($i == 0){
                                echo '<a href="inquiries.php">
                                <i class="fa fa-comments-o"></i> <span>Inquiries</span>
                            </a>';
                            }else{
                                echo '<a href="inquiries.php">
                                    <i class="fa fa-comments-o"></i> <span>Inquiries</span>
                                    <small class="badge pull-right bg-blue">'.$i.'</small>
                                </a>';
                            }
                            ?>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Content Management</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="contentManagement.php"><i class="fa fa-angle-double-right"></i> Add Skill</a></li>
                                <li><a href="enable_skill.php"><i class="fa fa-angle-double-right"></i> Enable Skills</a></li>
                                <li><a href="disable_skill.php"><i class="fa fa-angle-double-right"></i> Disable Skills</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $icon; ?> <?php echo $title;?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $title;?></li>
                    </ol>
                </section>

<script>
var $scores = $("#refresh");
setInterval(function () {
    $scores.load("index.php #refresh");
}, 5000);
</script>

<?php

    //$empId = $db -> fetchId();
    //echo ($empId + 1);
    //echo "<script>window.location = 'addEmployee.php?id=".$empId."'; </script>";
}
?>
