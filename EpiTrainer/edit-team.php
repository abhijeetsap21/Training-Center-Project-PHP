<?php
include("View/header.php");
require_once("Model/ProjectModel.php");
?>
<!---------------------------------------------------------
//	SCRIPT TO CHANGE MENU ACTIVE CLASS TO CURRENT PAGE
//--------------------------------------------------------->
<script type="text/javascript">
$(document).ready(function(){
        $("a").removeClass("active");
        $("#li-viewteam").addClass("active");
});
document.title = "Edit Team | EpiTrainer";
</script>

<h1 class="heading-top">Edit Team</h1>
<div class="content">
  
<?php
$messages = array();
switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    display_form();
    break;
  case "POST":
    do_post();
    break;
  default:
    die("Not implemented");
}

function display_form() {
  global $messages;
  $team_id = $_GET['tid'];
  global $team_details;
  
  //GET TEAM DETAILS
  $team_details = ProjectModel::getTeamDetails($team_id);
  
  //IF INVALID GET VALUE GIVEN FOR TEAM
  //REDIRECT BACK TO VIEW TEAM PAGE
  if(!$team_details){
    echo '<script type="text/javascript">alert("Team not found!"); </script>';          
          PersonModel::redirect("view-team.php");                                       
  }
  
  // Get input value if any
  if (!array_key_exists("summary", $messages)) {
    $messages["summary"] = "";
  }
  else {
    $messages["summary"] = "<span style='color: red;'>$messages[summary]</span>";
  }
  if (!array_key_exists("main", $messages)) {
    $messages["main"] = "";
  }
  else {
    $messages["main"] = "<span style='color: red;'>$messages[main]</span>";
  }
  
  // Print the form
  $owner_id = $_SESSION['isLoggedIn']['person_id'];
  $project_id = $team_details['project_id'];
  $project_details = ProjectModel::get($project_id);
  $project_name = $project_details["title"];
  $summary = $team_details["summary"];
  
  print <<<END_FORM
  <br><br><center>$messages[main]<br><br>
  <form method="POST" class="StyledForm">
  <table>
      <tr>
        <th>Owner Id:</th>
        <td><input type="text" name="owner_id" value="$owner_id" readonly /></td>
      </tr>
      <tr>
        <th>Project:</th>
        <td><select name="project_id"><option value="$project_id">$project_name</option></select></td>
      </tr>
      <tr>
        <th>Summary:*</th>
        <td><textarea rows="4" name="summary" cols="50" placeholder="Enter team summary here...">$summary</textarea>$messages[summary]
        <input type="hidden" name="team_id" value="$team_id">
        </td>
      </tr>
    </table>
    <img src="images/back.png" alt="Back" title="Back" onclick="history.go(-1);" style="margin: 0 20px -20px 0;cursor:pointer;" />
    <button type="submit">Update Team Summary</button>
  </form>
  </center>
END_FORM;
}

function do_post() {
  global $messages;
  $team_id = (empty($_POST["team_id"])) ? "" : (trim($_POST["team_id"]));
  $summary = (empty($_POST["summary"])) ? "" : (trim($_POST["summary"]));
  $owner_id = (empty($_POST["owner_id"])) ? "" : (trim($_POST["owner_id"]));
  
  //Check form values for errors
  if ($summary == "") {
    $messages["summary"] = "Enter team summary";
    display_form();
  }
  else if (strlen($summary) < 10) {
    $messages["summary"] = "Summary too short";
    display_form();
  }
  else if ($owner_id == "") {
    PersonModel::redirect("location:logout.php");
  }
  else {
        try {
        $update = ProjectModel::UpdateTeam($team_id, $summary);
        if($update){
          echo '<script type="text/javascript">alert("Summary updated successfully!"); </script>';
          PersonModel::redirect("view-team.php");
        }
        else{
          $messages["main"] = "Temporary error, try again later!";
            display_form();
        }
          
        } catch (PDOException $exc) {
          /* Each time we access a DB, an exception may occur */
          $msg = $exc->getMessage();
          $code = $exc->getCode();
          print "$msg (error code $code)";
        }
    
  }
}

?>

</div>

<?php
include("View/footer.php");
?>
