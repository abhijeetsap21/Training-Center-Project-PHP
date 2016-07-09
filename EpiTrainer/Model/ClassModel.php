<?php
require_once("DB.php");

/** Access to the Class tables. */
class ClassModel {

  /** Get class data for id $class_id */
  
  public static function get($class_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `class` WHERE `class_id` = :class_id");
    $stmt->bindValue(":class_id", $class_id);
    $ok = $stmt->execute();
    if ($ok) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      return false;
    }
  }
  
  /** Get all classes */
  
  public static function getClasses() {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `class`");
    $ok = $stmt->execute();
    if ($ok) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      return false;
    }
  }
  
  /**  Get Class Members  */
  
  public static function getClassMembers($class_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `class_member` WHERE `class_id` = :class_id");
    $stmt->bindValue(":class_id", $class_id);
    $stmt->execute();
    $class = $stmt->fetchAll();
      return $class;
  }
  
  /**  Create Select element for classes */
  
  public static function getClassSelect() {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `class`");
    $stmt->execute();
    $class = $stmt->fetchAll();
    $select = '';
    for($i=0; $i<count($class); $i++){
      $select .= '<option value="' .$class[$i]['class_id']. '">' .$class[$i]['name']. '</option>';
    }
    return $select;
  }
  
  /**  Get Class Name  */
  
  public static function showName($class_id) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `class` WHERE `class_id` = :class_id");
    $stmt->bindValue(":class_id", $class_id);
    $stmt->execute();
    $class = $stmt->fetch(PDO::FETCH_ASSOC);
    print $class["name"];;
  }
  

}

?>