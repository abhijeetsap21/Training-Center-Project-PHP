<?php
session_start();
require_once("Model/ClassModel.php");
require_once("Model/PersonModel.php");

$team_id = $_SESSION['team_id'];    //GET TEAM ID FROM SESSION
$person_id = $_SESSION['isLoggedIn']['person_id'];  //GET PERSON ID FROM SESSION
$class_id = PersonModel::getClass($person_id); //GET CLASS ID

try {
  $class_members = ClassModel::getClassMembers($class_id["class_id"]);  //GET CLASS MEMBERS
} catch (PDOException $exc) {
  $msg = $exc->getMessage();
  $code = $exc->getCode();
  print "$msg (error code $code)";
}
//---------------------------------------------------
//    DISPLAY CLASS MEMBERS
//---------------------------------------------------
print '<ul id="sortable2">';

for($i=0; $i<count($class_members); $i++){
    $sID = $class_members[$i]['person_id'];
    $student = json_decode(PersonModel::get($sID), true);
    if(!PersonModel::AlreadyInTeam($sID, $team_id)){    //DO NOT SHOW IF STUDENT IS ALREADY IN TEAM
        print "<li id=\"$sID \">
                <span></span>
                <img src=\"$student[picture_location]\">
                <div><h2>$student[first_name] $student[last_name]</h2>$student[email]</div>
            </li>";
    }
}

print '</ul>';

echo '<script type="text/javascript"> $( init ); </script>';    //INITIATE DRAGGABLE AGAIN FOR CHANGES

?>