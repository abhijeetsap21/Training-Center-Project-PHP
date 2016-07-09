<?php
session_start();
require_once("Model/ProjectModel.php");
require_once("Model/ClassModel.php");
require_once("Model/PersonModel.php");
if(!isset($_SESSION['isLoggedIn'])){
    PersonModel::redirect("login.php");
}
$team_id = $_GET['tid'];
if(!ProjectModel::getTeamDetails($team_id)){
    echo '<script type="text/javascript">alert("Team not found!"); </script>';
          PersonModel::redirect("view-team.php");
  }
$_SESSION['team_id'] = $team_id;
$person_id = $_SESSION['isLoggedIn']['person_id'];
$class_id = PersonModel::getClass($person_id);
$person = json_decode(PersonModel::get($person_id), true);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EpiTrainer</title>
<link rel="stylesheet" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<script type="text/javascript">
 
$( init );
 
function init() {
  $('#makeMeDraggable li').draggable();
  $('#makeMeDroppable li').draggable();
  $('#makeMeDroppable').droppable( {
    drop: handleDropEvent
  } );
  $('#makeMeDraggable').droppable( {
    drop: handleDropEventReverse
  } );
}
 
function handleDropEvent( event, ui ) {
  var draggable = ui.draggable;
  var draggable1 = draggable.attr('id');
  //var data = "?add=" + draggable1;
  var data = { 'add' : draggable1 };
  $.ajax({
          type: 'POST',
          url: 'getTable.php',
          data: data,
          success: function(data){
             $("#makeMeDroppable").html(data);
          } 
        });
  
  $.ajax({
          type: 'POST',
          url: 'getClass.php',
          success: function(data){
             $("#makeMeDraggable").html(data);
          } 
        });
  
}

function handleDropEventReverse( event, ui ) {
  var draggable = ui.draggable;
  var draggable1 = draggable.attr('id');
  //var data = "?add=" + draggable1;
  var data = { 'rem' : draggable1 };
  $.ajax({
          type: 'POST',
          url: 'getTable.php',
          data: data,
          success: function(data){
             $("#makeMeDroppable").html(data);
          } 
        });
  
  $.ajax({
          type: 'POST',
          url: 'getClass.php',
          success: function(data){
             $("#makeMeDraggable").html(data);
          } 
        });
  
}
 
</script>
</head>

<body>
    
    <div class="container">
        <div class="header">
            <img src="images/logo.png" alt="EpiTrainer Logo" style="margin-left: 375px;" />
            <div class="main_title_header">
              <ul>
                  <li><a id="li-home" class="active" href="index.php">Home</a></li>
                  
                      <?php if($person['is_trainer']=='1'){ ?>
                          <li><a id="li-addproject" href="add-project.php">New Project</a></li>
                          <li><a id="li-viewproject" href="view-project.php">Existing Projects</a></li>
                      <?php } else { ?>
                          <li><a id="li-addteam" href="add-team.php">New Team</a></li>
                          <li><a id="li-viewteam" href="view-team.php">Existing Teams</a></li>
                      <?php } ?>
                      
                  <li class="dropdown" style="float:right;background:brown;">
                      <a href="#" class="dropbtn">Hi, <?=$person['first_name']?>!</a>
                      <div class="dropdown-content">
                      <a href="#">My Profile</a>
                      <a href="#">Change Password</a>
                      <a href="logout.php">Logout</a>
                      </div>
                  </li>
              </ul>
            </div>
        </div><!-- header -->
        <h1 class="heading-top">Edit Members</h1>
        <div class="content">
        <h1 class="main_title">Team Members</h1>
        <div id="makeMeDroppable" style="min-height: 115px;background:cyan;border-style: dashed;">
        <?php
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
        <img src="images/back.png" alt="Back" title="Back" onclick="history.go(-1);" style="margin: 10px 20px -20px 0;cursor:pointer;" />
        </div><!-- content -->
        <div class="footer">
            Created by <a href="#">Samved Mohan Vajpeyi</a> and Abhijeet Pandey.
        </div><!-- footer -->
    </div><!-- container -->
</body>
</html>
