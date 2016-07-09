<?php

require_once("DB.php");

/** Access to the Project table. */
class ProjectModel {

  /** Get project data for id $project_id */
  public static function get($project_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `project` WHERE `project_id` = :project_id");
    $stmt->bindValue(":project_id", $project_id);
    $ok = $stmt->execute();
    if ($ok) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      return false;
    }
  }
  
  /** Get all projects of a particular trainer */
  
  public static function getMyProjects($person_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `project` WHERE `owner_id` = :person_id");
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    $project = $stmt->fetchAll();
      return $project;
  }
  
  /** Create html select element for Projects */
  
  public static function getProjectSelect($class_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `project` WHERE `class_id` = :class_id");
    $stmt->bindValue(":class_id", $class_id);
    $stmt->execute();
    $project = $stmt->fetchAll();
    $select = '';
    for($i=0; $i<count($project); $i++){
      $select .= '<option value="' .$project[$i]['project_id']. '">' .$project[$i]['title']. '</option>';
    }
    return $select;
  }
  
  /** Add a new project */
  
  public static function add($person_id, $class_id, $title, $deadline, $subject) {
    $db = DB::getConnection();
    $sql = "INSERT INTO `project`(`owner_id`, `class_id`, `title`, `deadline`, `subject`) VALUES (:person_id, :class_id, :title, :deadline, :subject)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":person_id", $person_id);
    $stmt->bindValue(":class_id", $class_id);
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":deadline", $deadline);
    $stmt->bindValue(":subject", $subject);
    $ok = $stmt->execute();
    if ($ok) {
      return true;
    }
    else{
      return false;
    }
  }
  
  /** Update Project */
  
  public static function Update($project_id, $title, $deadline, $subject) {
    $db = DB::getConnection();
    $stmt = $db->prepare("UPDATE `project` SET `title` = :title , `deadline` = :deadline , `subject` = :subject WHERE `project_id` = :project_id");
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":deadline", $deadline);
    $stmt->bindValue(":subject", $subject);
    $stmt->bindValue(":project_id", $project_id);
    $ok = $stmt->execute();
    if ($ok) {
      return true;
    }
    else{
      return false;
    }
  }
  
  /** Update team */
  
  public static function UpdateTeam($team_id, $summary) {
    $db = DB::getConnection();
    $stmt = $db->prepare("UPDATE `team` SET `summary` = :summary WHERE `team_id` = :team_id");
    $stmt->bindValue(":team_id", $team_id);
    $stmt->bindValue(":summary", $summary);
    $ok = $stmt->execute();
    if ($ok) {
      return true;
    }
    else{
      return false;
    }
  }
  
  /** Add new team */
  
  public static function addTeam($project_id, $owner_id, $summary) {
    $db = DB::getConnection();
    $sql = "INSERT INTO `team`(`project_id`, `owner_id`, `summary`) VALUES (:project_id, :owner_id, :summary)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":project_id", $project_id);
    $stmt->bindValue(":owner_id", $owner_id);
    $stmt->bindValue(":summary", $summary);
    $ok = $stmt->execute();
    $team_id = $db->lastInsertId();
    $_SESSION['team_id'] = $team_id;
    if ($ok) {
      $stmt = $db->prepare("INSERT INTO `team_member`(`team_id`, `student_id`) VALUES (:team_id, :student_id)");
      $stmt->bindValue(":team_id", $team_id);
      $stmt->bindValue(":student_id", $owner_id);
      $stmt->execute();
        return true;
    }
    else{
      return false;
    }
  }
  
  /** Get team members */
  
  public static function getTeam($team_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `team_member` WHERE `team_id` = :team_id");
    $stmt->bindValue(":team_id", $team_id);
    $stmt->execute();
    $team = $stmt->fetchAll();
      return json_encode($team);
  }
  
  /** Get team details */
  
  public static function getTeamDetails($team_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `team` WHERE `team_id` = :team_id");
    $stmt->bindValue(":team_id", $team_id);
    $ok = $stmt->execute();
    if($ok){
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      return false;
    }
  }
  
  /** Get all teams of a particular owner */
  
  public static function getMyTeams($person_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `team` WHERE `owner_id` = :person_id");
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    $team = $stmt->fetchAll();
      return $team;
  }
  
  /** Get teams for a project */
  
  public static function getTeamByProject($project_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `team` WHERE `project_id` = :project_id");
    $stmt->bindValue(":project_id", $project_id);
    $stmt->execute();
    $team = $stmt->fetchAll();
      return $team;
  }
  
  /** Print person's name */
  
  public static function showName($person_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `person` WHERE `person_id` = :person_id");
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    print $name['first_name'].' '.$name['last_name'];
  }
  
  /** Return person's name */
  
  public static function getName($person_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `person` WHERE `person_id` = :person_id");
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    $val = $name['first_name'].' '.$name['last_name'];
    return $val;
  }

  

}

?>