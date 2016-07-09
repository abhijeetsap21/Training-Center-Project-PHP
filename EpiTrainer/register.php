<?php
session_start();
require_once("Model/PersonModel.php");
/** Exemple of a form sent to the same url */
// Error messages
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
  // Use global variable $messages
  global $messages;
  // Get input value if any
  $fname = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["fname"];
  if (!array_key_exists("fname", $messages)) {
    $messages["fname"] = "";
  }
  else {
    $messages["fname"] = "<span style='color: red;'>$messages[fname]</span>";
  }
  
  $lname = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["lname"];
  if (!array_key_exists("lname", $messages)) {
    $messages["lname"] = "";
  }
  else {
    $messages["lname"] = "<span style='color: red;'>$messages[lname]</span>";
  }
  
  $addr1 = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["addr1"];
  if (!array_key_exists("addr1", $messages)) {
    $messages["addr1"] = "";
  }
  else {
    $messages["addr1"] = "<span style='color: red;'>$messages[addr1]</span>";
  }
  
  $addr2 = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["addr2"];
  if (!array_key_exists("addr2", $messages)) {
    $messages["addr2"] = "";
  }
  else {
    $messages["addr2"] = "<span style='color: red;'>$messages[addr2]</span>";
  }
  
  $zip = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["zip"];
  if (!array_key_exists("zip", $messages)) {
    $messages["zip"] = "";
  }
  else {
    $messages["zip"] = "<span style='color: red;'>$messages[zip]</span>";
  }
  
  $city = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["city"];
  if (!array_key_exists("city", $messages)) {
    $messages["city"] = "";
  }
  else {
    $messages["city"] = "<span style='color: red;'>$messages[city]</span>";
  }
  
  $email = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["email"];
  if (!array_key_exists("email", $messages)) {
    $messages["email"] = "";
  }
  else {
    $messages["email"] = "<span style='color: red;'>$messages[email]</span>";
  }
  
  $mobile = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["mobile"];
  if (!array_key_exists("mobile", $messages)) {
    $messages["mobile"] = "";
  }
  else {
    $messages["mobile"] = "<span style='color: red;'>$messages[mobile]</span>";
  }
  
  $tel = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["tel"];
  if (!array_key_exists("tel", $messages)) {
    $messages["tel"] = "";
  }
  else {
    $messages["tel"] = "<span style='color: red;'>$messages[tel]</span>";
  }
  
  $pass = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["pass"];
  if (!array_key_exists("pass", $messages)) {
    $messages["pass"] = "";
  }
  else {
    $messages["pass"] = "<span style='color: red;'>$messages[pass]</span>";
  }
  
  $cpass = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["cpass"];
  if (!array_key_exists("cpass", $messages)) {
    $messages["cpass"] = "";
  }
  else {
    $messages["cpass"] = "<span style='color: red;'>$messages[cpass]</span>";
  }
  // Print the form
  print <<<END_FORM
  <br><br><br><center>
  <form method="POST">
    First name:*
    <input type="text" name="fname" value="$fname" placeholder="Enter first name" required />$messages[fname]
    <br/><br/>
    Last name:*
    <input type="text" name="lname" value="$lname" placeholder="Enter last name" required />$messages[lname]
    <br/><br/>
    Address:*
    <input type="text" name="addr1" value="$addr1" placeholder="Address line 1" required />$messages[addr1]
    <br/><br/>
    <input type="text" name="addr2" value="$addr2" placeholder="Address line 2 (optional)" />$messages[addr2]
    <br/><br/>
    Zip Code:*
    <input type="text" name="zip" value="$zip" required />$messages[zip]
    <br/><br/>
    City:*
    <input type="text" name="city" value="$city" required />$messages[city]
    <br/><br/>
    Email:*
    <input type="email" name="email" value="$email" required />$messages[email]
    <br/><br/>
    Mobile No.:*
    <input type="tel" name="mobile" value="$mobile" required />$messages[mobile]
    <br/><br/>
    Phone:
    <input type="tel" name="tel" value="$tel" />$messages[tel]
    <br/><br/>
    Password:*
    <input type="password" name="pass" value="$pass"/>$messages[pass]
    <br/><br/>
    Confirm Password:*
    <input type="password" name="cpass" value="$cpass"/>$messages[cpass]
    <br/><br/>
    <input type="checkbox" name="isTrainer" value="isTrainer"> Trainer Rights
    <br/>
    <input type="checkbox" name="isAdmin" value="isAdmin"> Admin Rights
    <br/><br/>
    <button type="submit">Register</button>
  </form>
  </center>
END_FORM;
}

function do_post() {
  global $messages;
  $fname = (empty($_POST["fname"])) ? "" : (trim($_POST["fname"]));
  $lname = (empty($_POST["lname"])) ? "" : (trim($_POST["lname"]));
  $addr1 = (empty($_POST["addr1"])) ? "" : (trim($_POST["addr1"]));
  $addr2 = (empty($_POST["addr1"])) ? "" : (trim($_POST["addr2"]));
  $zip = (empty($_POST["zip"])) ? "" : (trim($_POST["zip"]));
  $city = (empty($_POST["city"])) ? "" : (trim($_POST["city"]));
  $email = (empty($_POST["email"])) ? "" : (trim($_POST["email"]));
  $mobile = (empty($_POST["mobile"])) ? "" : (trim($_POST["mobile"]));
  $tel = (empty($_POST["tel"])) ? "" : (trim($_POST["tel"]));
  $pass = (empty($_POST["pass"])) ? "" : (trim($_POST["pass"]));
  $cpass = (empty($_POST["cpass"])) ? "" : (trim($_POST["cpass"]));
  $isTrainer = (empty($_POST["isTrainer"])) ? "" : (trim($_POST["isTrainer"]));
  $isAdmin = (empty($_POST["isAdmin"])) ? "" : (trim($_POST["isAdmin"]));
  if ($fname == "") {
    $messages["fname"] = "Enter Firstname";
    display_form();
  }
  else if (strlen($fname) < 3) {
    $messages["fname"] = "Firstname must have at least 3 characters";
    display_form();
  }
  else if ($lname == "") {
    $messages["lname"] = "Enter Lastname";
    display_form();
  }
  else if (strlen($lname) < 3) {
    $messages["lname"] = "Lastname must have at least 3 characters";
    display_form();
  }
  else if ($addr1 == "") {
    $messages["addr1"] = "Enter Address";
    display_form();
  }
  else if ($zip == "") {
    $messages["zip"] = "Enter Zip Code";
    display_form();
  }
  else if ($city == "") {
    $messages["city"] = "Enter City";
    display_form();
  }
  else if ($email == "") {
    $messages["email"] = "Enter Email ID";
    display_form();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $messages["email"] = "Invalid Email Address";
    display_form();
  }
  else if ($mobile == "") {
    $messages["mobile"] = "Enter Mobile Number";
    display_form();
  }
  else if ($pass == "") {
    $messages["pass"] = "Enter Password";
    display_form();
  }
  else if ($cpass == "") {
    $messages["cpass"] = "Enter Confirm Passwod";
    display_form();
  }
  else if (strlen($pass) < 3) {
    $messages["pass"] = "Password must have at least 3 characters";
    display_form();
  }
  else if ($pass != $cpass) {
    $messages["pass"] = "Passwords do not match!";
    $messages["cpass"] = "!";
    display_form();
  }
  else if(!PersonModel::checkemail($email)){
    $messages["email"] = "Email already exists, click if you<a href='#'>forgot password</a>";
    display_form();
  }
  else {
        $pass_md5 = md5($pass);
        $addr = $addr1 ." \n ". $addr2;
        if($isTrainer=="isTrainer"){ $isTrainer = "1"; } else { $isTrainer = "0"; }
        if($isAdmin=="isAdmin"){ $isAdmin = "1"; } else { $isAdmin = "0"; }
        $created = date("Y-m-d H:i:s");
        $conf_token = PersonModel::generateRandomString();
        $renew_token = PersonModel::generateRandomString();
        
        try {
        $register = PersonModel::register($fname, $lname, $addr, $zip, $city, $email, $mobile, $tel, $pass_md5, $isTrainer, $isAdmin, $created, $conf_token, $renew_token);
        if($register){
          print "Registration Successful!";
        }
        else{
          print "Registration FAILED!<br><br>";
        }
          
        } catch (PDOException $exc) {
          /* Each time we access a DB, an exception may occur */
          $msg = $exc->getMessage();
          $code = $exc->getCode();
          print "$msg (error code $code)";
        }
    
  }
}
