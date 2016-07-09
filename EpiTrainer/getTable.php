<?php
session_start();
require_once("Model/ProjectModel.php");
require_once("Model/PersonModel.php");

$team_id = $_SESSION['team_id'];	//GET TEAM ID FROM SESSION

//---------------------------------------------------
//	IF ADD STUDENT INVOKED
//---------------------------------------------------
if(isset($_POST['add'])){
    $studentID = $_POST['add'];
    try {
	    $db = DB::getConnection();
	    $sql  = 'INSERT INTO `team_member`(`team_id`, `student_id`) VALUES (:team_id, :student_id)';
	    $query = $db->prepare($sql);
	    $query->bindParam(':team_id', $team_id, PDO::PARAM_INT);
	    $query->bindParam(':student_id', $studentID, PDO::PARAM_INT);
	    $query->execute();
	} catch (PDOException $e) {
	    echo 'PDOException : '.  $e->getMessage();
	}
}
//---------------------------------------------------
//	IF REMOVE STUDENT INVOKED
//---------------------------------------------------
if(isset($_POST['rem'])){
    $studentID = $_POST['rem'];
    $personID = $_SESSION['isLoggedIn']['person_id'];
    if(trim($studentID) != trim($personID)){
	    try {
	    $db = DB::getConnection();
	    $sql  = 'DELETE FROM `team_member` WHERE `team_id` = :team_id AND `student_id` = :student_id';
	    $query = $db->prepare($sql);
	    $query->bindParam(':team_id', $team_id, PDO::PARAM_INT);
	    $query->bindParam(':student_id', $studentID, PDO::PARAM_INT);
	    $query->execute();
	}
    catch (PDOException $e) {
	    echo 'PDOException : '.  $e->getMessage();
	}
    }
}

//---------------------------------------------------
//	LOAD/REFRESH TEAM AGAIN
//---------------------------------------------------
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

echo '<script type="text/javascript"> $( init ); </script>';	//INITIALIZE DRAGGABLE AGAIN FOR CHANGES

?>