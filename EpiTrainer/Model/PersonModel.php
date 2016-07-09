<?php
//session_start();
require_once("DB.php");

/** Access to the person table  */
class PersonModel {

  /** Get person data for id $personId */
  
  public static function get($personId) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `person` WHERE `person_id` = :person_id");
    $stmt->bindValue(":person_id", $personId);
    $ok = $stmt->execute();
    if ($ok) {
      return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    }
    else{
      return false;
    }
  }
  
  /** Get class of person **/
  
  public static function getClass($personId) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `class_member` WHERE `person_id` = :person_id");
    $stmt->bindValue(":person_id", $personId);
    $ok = $stmt->execute();
    if ($ok) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      return false;
    }
  }
  
  /** Check Login details **/
  
  public static function checklogin($email, $pass) {
    $db = DB::getConnection();
    $stmt = $db->prepare("SELECT * FROM `person` WHERE `email` = :email AND `password` = :pass");
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":pass", $pass);
    $ok = $stmt->execute();
    if ($ok) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      return false;
    }
    
  }
  
  /** Check if Email already exists **/
  
  public static function checkemail($email) {
    $db = DB::getConnection();
    $sql = "SELECT *
              FROM `person`
              WHERE `email` = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    if ($stmt->fetchColumn()>=1) {
      return false;
    }
    else{
      return true;
    }
  }
  
  /** Check if person is already in team **/
  
  public static function AlreadyInTeam($person_id, $team_id) {
    $db = DB::getConnection();
    $sql = "SELECT *
              FROM `team_member`
              WHERE `team_id` = :team_id AND `student_id` = :person_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":team_id", $team_id);
    $stmt->bindValue(":person_id", $person_id);
    $stmt->execute();
    if ($stmt->fetchColumn()>=1) {
      return true;
    }
    else{
      return false;
    }
  }
  
  /** Register Function **/
  
  public static function register($fname, $lname, $addr, $zip, $city, $email, $mobile, $tel, $pass_md5, $isTrainer, $isAdmin, $created, $conf_token, $renew_token) {
    $db = DB::getConnection();
    $sql = "INSERT INTO `person`(`first_name`, `last_name`, `address`, `zip_code`, `town`, `email`, `mobile_phone`, `phone`, `is_trainer`, `is_admin`, `password`, `created_at`, `confirmation_token`, `renew_password_token`) VALUES (:fname, :lname, :addr, :zip, :city, :email, :mobile, :tel, :isTrainer, :isAdmin, :pass_md5, :created, :conf_token, :renew_token) ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":fname", $fname);
    $stmt->bindValue(":lname", $lname);
    $stmt->bindValue(":addr", $addr);
    $stmt->bindValue(":zip", $zip);
    $stmt->bindValue(":city", $city);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":mobile", $mobile);
    $stmt->bindValue(":tel", $tel);
    $stmt->bindValue(":isTrainer", $isTrainer);
    $stmt->bindValue(":isAdmin", $isAdmin);
    $stmt->bindValue(":pass_md5", $pass_md5);
    $stmt->bindValue(":created", $created);
    $stmt->bindValue(":conf_token", $conf_token);
    $stmt->bindValue(":renew_token", $renew_token);
    $ok = $stmt->execute();
    if ($ok) {
      return true;
    }
    else{
      return false;
    }
  }
  
  /** Generate random string fucntion for confirmation and renew password tokens **/
  
  public static function generateRandomString() {
    $length = 12;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
  }
  
  /** Using custom redirect function as php Header function not always works for PDO**/
  
  public static function redirect($url){
    if (headers_sent()){
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    }else{
      header('Location: ' . $url);
      die();
    }    
}

}

?>