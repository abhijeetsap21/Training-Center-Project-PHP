<?php
session_start();
require_once("Model/ProjectModel.php");
require_once("Model/ClassModel.php");
require_once("Model/PersonModel.php");

if(!isset($_SESSION['isLoggedIn'])){
    PersonModel::redirect("login.php");
}
$team_id = $_SESSION['team_id'];
$person_id = $_SESSION['isLoggedIn']['person_id'];
$class_id = PersonModel::getClass($person_id);
$person = json_decode(PersonModel::get($_SESSION['isLoggedIn']['person_id']), true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Drag and Drop using jQuery and Ajax</title>
    <link rel="stylesheet" href="css/style.css" />
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
    <script type="text/javascript"> $( init ); </script>
</head>
<body>
    
    <div class="container">
        <div class="header">
            <img src="images/logo.png" alt="EpiTrainer Logo" style="margin-left: 375px;" />
            <div class="main_title_header">
                <ul>
                    <li><a id="li-home" href="index.php">Home</a></li>
                      <!-----------------------------------------------------
                      //SHOW MENUS FOR TRAINER OR STUDENT ACCORDINGLY
                      //----------------------------------------------------->
                        <?php if($person['is_trainer']=='1'){ ?>
                            <li><a id="li-addproject" href="add-project.php">New Project</a></li>
                            <li><a id="li-viewproject" href="view-project.php">Existing Projects</a></li>
                        <?php } else { ?>
                            <li><a id="li-addteam" class="active" href="add-team.php">New Team</a></li>
                            <li><a id="li-viewteam" href="view-team.php">Existing Teams</a></li>
                        <?php } ?>
                        
                    <li class="dropdown" style="float:right;background:brown;">
                        <a href="#" class="dropbtn">Hi, <?=$person['first_name']?>!</a>
                        <div class="dropdown-content">
                        <a href="profile.php?pid=<?=$_SESSION['isLoggedIn']['person_id']?>">My Profile</a>
                        <a href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- header -->
        <h1 class="heading-top">Add/Remove Members</h1>
        <div class="content">
        <h1 class="main_title">Team Members</h1>
        <div id="makeMeDroppable" style="min-height: 115px;background:cyan;border-style: dashed;">
        <?php
            ///////////////////////////////////////
            //          Get team members         //
            ///////////////////////////////////////
            try {
              $team = json_decode(ProjectModel::getTeam($team_id), true);
            } catch (PDOException $exc) {
              $msg = $exc->getMessage();
              $code = $exc->getCode();
              print "$msg (error code $code)";
            }
            
            print '<ul id="sortable">';
            
            for($i=0; $i<count($team); $i++){
                $student = json_decode(PersonModel::get($team[$i]["student_id"]), true);
                $sID = $team[$i]["student_id"];
                print "<li id=\"$sID \">
                            <span></span>
                            <img src=\"$student[picture_location]\">
                            <div><h2>$student[first_name] $student[last_name]</h2>$student[email]</div>
                        </li>";
            }
            
            print '</ul>';
        ?>
        </div>
        <h1 class="main_title">Students List (Drag-n-Drop to the above list)</h1>
        <div id="makeMeDraggable" style="min-height: 120px;background:antiquewhite;">
        <?php
            ///////////////////////////////////////
            //   Get class members not in team   //
            ///////////////////////////////////////
            try {
            $class_members = ClassModel::getClassMembers($class_id["class_id"]);
            } catch (PDOException $exc) {
            $msg = $exc->getMessage();
            $code = $exc->getCode();
            print "$msg (error code $code)";
            }
            
            print '<ul id="sortable2">';
            
            for($i=0; $i<count($class_members); $i++){
            $sID = $class_members[$i]['person_id'];
            $student = json_decode(PersonModel::get($sID), true);
            
            if(!PersonModel::AlreadyInTeam($sID, $team_id)){
        print "<li id=\"$sID \">
                <span></span>
                <img src=\"$student[picture_location]\">
                <div><h2>$student[first_name] $student[last_name]</h2>$student[email]</div>
            </li>";
            }
            }
            
            print '</ul>';
        ?>
        </div>
        <form class="StyledForm"><button onclick="return saveMembers();">That's it... Done</button></form>
        </div><!-- content -->
        <div class="footer">
            Created by <a href="#">Samved Mohan Vajpeyi</a> and Abhijeet Pandey.
        </div><!-- footer -->
    </div><!-- container -->
</body>
</html>
