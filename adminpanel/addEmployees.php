<?php
    //session_start();
    
?>
<!DOCTYPE html>
<html>
    <head>
        <?php 
            $title = "Add Employee";
            $icon = '<i class="fa fa-group"></i>';
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

            <form id="msform" method="POST" enctype="multipart/form-data">
            <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active">Personal Details</li>
                    <li>Available Schedule</li>
                    <li>Additional Information</li>
                    <li>Account Setup</li>
                </ul>
                <!-- fieldsets -->
                <fieldset style="margin-bottom:50px;">
                        <div class="alert alert-success" id="alert" style="visibility: true; display: block; width:90%;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> A new employee has been added.
                        </div>
                    <h2 class="fs-title">ADD EMPLOYEE</h2>
                    <label style="float:left;"><i class="fa fa-edit"></i> Personal Details</label>
                    <input type="text" name="fname" placeholder="First Name" id="firstName" required/>
                    <input type="text" name="lname" placeholder="Last Name" id="lastName" required/>
                    <input type="address" name="address" placeholder="Address" id="address" required/>
                    <input type="text" name="contact" placeholder="Contact" maxlength="11" id="contact" required/>
                    <input type="email" name="email" placeholder="Email" id="email" required/>
                    <label style="float:left;"><i class="fa fa-calendar"></i> Birthdate</label>
                    <input type="date" name="birthdate" placeholder="Birthdate" id="birthdate" required/>
                    <input type="button" name="next" class="next action-button" value="Next" />

                </fieldset>

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
                                            <input type="hidden" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.0"></input>
                                            <td><input type="checkbox" name="availabletime[1]" value="9:00 - 10:00 AM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[2]" value="9:00 - 10:00 AM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[3]" value="9:00 - 10:00 AM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[4]" value="9:00 - 10:00 AM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[5]" value="9:00 - 10:00 AM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[6]" value="9:00 - 10:00 AM.Saturday.1"></input ></td>
                                            <input type="hidden" name="availabletime[7]" value="9:00 - 10:00 AM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[7]" value="9:00 - 10:00 AM.Sunday.1"></input ></td>
                                            
                                        </tr>
                                        <tr>
                                            <td>10:00 - 11:00 AM</td>
                                            <input type="hidden" name="availabletime[8]" value="10:00 - 11:00 AM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[8]" value="10:00 - 11:00 AM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[9]" value="10:00 - 11:00 AM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[9]" value="10:00 - 11:00 AM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[10]" value="10:00 - 11:00 AM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[10]" value="10:00 - 11:00 AM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[11]" value="10:00 - 11:00 AM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[11]" value="10:00 - 11:00 AM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[12]" value="10:00 - 11:00 AM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[12]" value="10:00 - 11:00 AM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[13]" value="10:00 - 11:00 AM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[13]" value="10:00 - 11:00 AM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[14]" value="10:00 - 11:00 AM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[14]" value="10:00 - 11:00 AM.Sunday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>11:00 - 12:00 PM</td>
                                            <input type="hidden" name="availabletime[15]" value="11:00 - 12:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[15]" value="11:00 - 12:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[16]" value="11:00 - 12:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[16]" value="11:00 - 12:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[17]" value="11:00 - 12:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[17]" value="11:00 - 12:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[18]" value="11:00 - 12:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[18]" value="11:00 - 12:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[19]" value="11:00 - 12:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[19]" value="11:00 - 12:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[20]" value="11:00 - 12:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[20]" value="11:00 - 12:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[21]" value="11:00 - 12:00 PM.SUnday.0">
                                            <td><input type="checkbox" name="availabletime[21]" value="11:00 - 12:00 PM.Sunday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>12:00 - 1:00 PM</td>
                                            <input type="hidden" name="availabletime[22]" value="12:00 - 1:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[22]" value="12:00 - 1:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[23]" value="12:00 - 1:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[23]" value="12:00 - 1:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[24]" value="12:00 - 1:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[24]" value="12:00 - 1:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[25]" value="12:00 - 1:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[25]" value="12:00 - 1:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[26]" value="12:00 - 1:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[26]" value="12:00 - 1:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[27]" value="12:00 - 1:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[27]" value="12:00 - 1:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[28]" value="12:00 - 1:00 PM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[28]" value="12:00 - 1:00 PM.Sunday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>1:00 - 2:00 PM</td>
                                            <input type="hidden" name="availabletime[29]" value="1:00 - 2:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[29]" value="1:00 - 2:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[30]" value="1:00 - 2:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[30]" value="1:00 - 2:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[31]" value="1:00 - 2:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[31]" value="1:00 - 2:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[32]" value="1:00 - 2:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[32]" value="1:00 - 2:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[33]" value="1:00 - 2:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[33]" value="1:00 - 2:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[34]" value="1:00 - 2:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[34]" value="1:00 - 2:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[35]" value="1:00 - 2:00 PM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[35]" value="1:00 - 2:00 PM.Sunday.1"></input></td>

                                        </tr>
                                        <tr>
                                            <td>2:00 - 3:00 PM</td>
                                            <input type="hidden" name="availabletime[36]" value="2:00 - 3:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[36]" value="2:00 - 3:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[37]" value="2:00 - 3:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[37]" value="2:00 - 3:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[38]" value="2:00 - 3:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[38]" value="2:00 - 3:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[39]" value="2:00 - 3:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[39]" value="2:00 - 3:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[40]" value="2:00 - 3:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[40]" value="2:00 - 3:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[41]" value="2:00 - 3:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[41]" value="2:00 - 3:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[42]" value="2:00 - 3:00 PM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[42]" value="2:00 - 3:00 PM.Sunday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>3:00 - 4:00 PM</td>
                                            <input type="hidden" name="availabletime[43]" value="3:00 - 4:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[43]" value="3:00 - 4:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[44]" value="3:00 - 4:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[44]" value="3:00 - 4:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[45]" value="3:00 - 4:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[45]" value="3:00 - 4:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[46]" value="3:00 - 4:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[46]" value="3:00 - 4:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[47]" value="3:00 - 4:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[47]" value="3:00 - 4:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[48]" value="3:00 - 4:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[48]" value="3:00 - 4:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[49]" value="3:00 - 4:00 PM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[49]" value="3:00 - 4:00 PM.Sunday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>4:00 - 5:00 PM</td>
                                            <input type="hidden" name="availabletime[50]" value="4:00 - 5:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[50]" value="4:00 - 5:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[51]" value="4:00 - 5:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[51]" value="4:00 - 5:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[52]" value="4:00 - 5:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[52]" value="4:00 - 5:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[53]" value="4:00 - 5:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[53]" value="4:00 - 5:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[54]" value="4:00 - 5:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[54]" value="4:00 - 5:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[55]" value="4:00 - 5:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[55]" value="4:00 - 5:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[56]" value="4:00 - 5:00 PM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[56]" value="4:00 - 5:00 PM.Sunday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>5:00 - 6:00 PM</td>
                                            <input type="hidden" name="availabletime[57]" value="5:00 - 6:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[57]" value="5:00 - 6:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[58]" value="5:00 - 6:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[58]" value="5:00 - 6:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[59]" value="5:00 - 6:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[59]" value="5:00 - 6:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[60]" value="5:00 - 6:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[60]" value="5:00 - 6:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[61]" value="5:00 - 6:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[61]" value="5:00 - 6:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[62]" value="5:00 - 6:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[62]" value="5:00 - 6:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[63]" value="5:00 - 6:00 PM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[63]" value="5:00 - 6:00 PM.Sunday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>6:00 - 7:00 PM</td>
                                            <input type="hidden" name="availabletime[64]" value="6:00 - 7:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[64]" value="6:00 - 7:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[65]" value="6:00 - 7:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[65]" value="6:00 - 7:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[66]" value="6:00 - 7:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[66]" value="6:00 - 7:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[67]" value="6:00 - 7:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[67]" value="6:00 - 7:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[68]" value="6:00 - 7:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[68]" value="6:00 - 7:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[69]" value="6:00 - 7:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[69]" value="6:00 - 7:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[70]" value="6:00 - 7:00 PM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[70]" value="6:00 - 7:00 PM.Sunday.1"></input></td>
                                        </tr>
                                        <tr>
                                            <td>7:00 - 8:00 PM</td>
                                            <input type="hidden" name="availabletime[71]" value="7:00 - 8:00 PM.Monday.0">
                                            <td><input type="checkbox" name="availabletime[71]" value="7:00 - 8:00 PM.Monday.1"></input></td>
                                            <input type="hidden" name="availabletime[72]" value="7:00 - 8:00 PM.Tuesday.0">
                                            <td><input type="checkbox" name="availabletime[72]" value="7:00 - 8:00 PM.Tuesday.1"></input></td>
                                            <input type="hidden" name="availabletime[73]" value="7:00 - 8:00 PM.Wednesday.0">
                                            <td><input type="checkbox" name="availabletime[73]" value="7:00 - 8:00 PM.Wednesday.1"></input></td>
                                            <input type="hidden" name="availabletime[74]" value="7:00 - 8:00 PM.Thursday.0">
                                            <td><input type="checkbox" name="availabletime[74]" value="7:00 - 8:00 PM.Thursday.1"></input></td>
                                            <input type="hidden" name="availabletime[75]" value="7:00 - 8:00 PM.Friday.0">
                                            <td><input type="checkbox" name="availabletime[75]" value="7:00 - 8:00 PM.Friday.1"></input></td>
                                            <input type="hidden" name="availabletime[76]" value="7:00 - 8:00 PM.Saturday.0">
                                            <td><input type="checkbox" name="availabletime[76]" value="7:00 - 8:00 PM.Saturday.1"></input></td>
                                            <input type="hidden" name="availabletime[77]" value="7:00 - 8:00 PM.Sunday.0">
                                            <td><input type="checkbox" name="availabletime[77]" value="7:00 - 8:00 PM.Sunday.1"></input></td>
                                        </tr>
                                    </table>
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>

                <fieldset style="margin-bottom:50px;">
                    <h2 class="fs-title">Additional Information</h2>
                    <input type="hidden" name="pic" value="../adminpanel/img/users/default.jpg" />
                    <i class="fa fa-camera"></i><b>Profile Picture</b></label><br>
                    <input data-label="Upload" class="demo" type="file" name="picture" id="picture"/>
                    <i class="fa fa-user"></i><b>Employee Type</b></label><br>
                        <div class="radio">
                            <input type="radio"  name="type" value="Draftsman" required>
                            Draftsman &nbsp;&nbsp;
                            <input type="radio" name="type" value="Tutorial" required>
                            Tutor &nbsp;&nbsp;
                            <input type="radio" name="type" value="Draftsman/Tutor" required>
                            Draftsman/Tutor
                        </div>
                    <i class="fa fa-pencil"></i><b>Skills</b></label><br>
                                                
                            <select id="select" multiple="multiple" name="skill[]">
                                <?php
                                    $query = $dbh->query("SELECT skillName as `sk`, skillID as `sid` FROM skills");
                                    while($row = $query->fetch()){
                                        echo "<option value='".$row['sid']."'>".$row['sk']."";
                                    }
                                ?>
                            </select><br>

                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>

                <fieldset style="margin-bottom:50px;">
                    <h2 class="fs-title">Account Setup</h2>
                    <label for="username" style="float: left;"><i class="fa fa-user"></i>Username</label><input type="text" name="username" placeholder="Username" required/>
                    <label for="password" style="float: left;"><i class="fa fa-lock"></i>Password</label><input type="password" name="password" placeholder="Password" required/>
                    <input type="password" name="cpassword" placeholder="Confirm Password" required/>
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="submit" name="submit" class="submit action-button" value="Submit" />
                </fieldset>

            </form>
        </section><!-- /.content -->
    </body>
</html>

<?php

    global $dbh;
    try {
        if(isset($_POST['submit'])){

        $count = 0;
        $foo = $_REQUEST['availabletime'];
        foreach ($foo as $n){
            list($a,$b,$c) = explode(".", $n);
            if($c == 1){
                $count++;
            }
        }

        $string = $_REQUEST['availabletime'];
        $string2 = $_REQUEST['skill'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $availabletime = $count;
        $pic = $_POST['pic'];
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $type = $_POST['type'];

        date_default_timezone_set('Asia/Manila');
            $ctime = date("h:i");
            $date = date("Y-m-d");
            $msg = '<b>'.$fname." ".$lname."</b> has been added to the employee list.";
            $icon = "fa fa-user bg-green";


        echo $db -> addEmployee($fname,$lname,$contact,$address,$email,$birthdate,$availabletime,$pic,$user,$pass,$type);

        foreach ($string as $name){
            list($time,$day,$availability) = explode(".", $name);
            echo $db -> insertSchedule($day,$time,$availability);
        }

        foreach ($string2 as $skill){
            echo $db -> insertSkill($skill);
        }

        //echo $db -> addAccount($empid,$user,$pass,$type);
        echo $db -> addEmployeeTimeline($id,$msg,$ctime,$date,$icon);
        echo "<script>window.location = 'addEmployees.php?id=".$GLOBALS['empid']."'; </script>";

            
        }
        
    } catch (PDOException $e) {
        
    }



 


?>