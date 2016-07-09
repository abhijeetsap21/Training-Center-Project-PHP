<?php
include("View/header.php");
?>
<h1 class="heading-top">Login</h1>
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
  // Use global variable $messages
  global $messages;
  // Get input value if any
  $email = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["email"];
  if (!array_key_exists("email", $messages)) {
    $messages["email"] = "";
  }
  else {
    $messages["email"] = "<span style='color: red;'>$messages[email]</span>";
  }
  $pass = ($_SERVER["REQUEST_METHOD"] == "GET") ? "" : $_POST["pass"];
  if (!array_key_exists("pass", $messages)) {
    $messages["pass"] = "";
  }
  else {
    $messages["pass"] = "<span style='color: red;'>$messages[pass]</span>";
  }
  if (!array_key_exists("main", $messages)) {
    $messages["main"] = "";
  }
  else {
    $messages["main"] = "<span style='color: red;'>$messages[main]</span>";
  }
  // Print the form
  print <<<END_FORM
  <center>$messages[main]<br><br>
  <form method="POST" class="StyledForm">
    <table>
      <tr>
        <th>Enter Email Id:</th>
        <td><input type="email" name="email" value="$email"/></td>
        <td>$messages[email]</td>
      </tr>
      <tr>
        <th>Enter Password:</th>
        <td><input type="password" name="pass" value="$pass"/></td>
        <td>$messages[pass]</td>
      </tr>
    </table>
    <small><a href="#">Forgot Password?</a></small>
    <br/><br/>
    <button type="submit">Login</button>
    <button type="reset">Reset</button>
  </form>
  </center>
END_FORM;
}

function do_post() {
  global $messages;
  $email = (empty($_POST["email"])) ? "" : (trim($_POST["email"]));
  $pass = (empty($_POST["pass"])) ? "" : (trim($_POST["pass"]));
  $pass_md5 = md5($pass);
  if ($email== "") {
    $messages["email"] = "Enter Email Id";
    display_form();
  }
  else if ($pass == "") {
    $messages["pass"] = "Enter Password";
    display_form();
  }
  else {
        try {
          $login = PersonModel::checklogin($email,$pass_md5);
          if($login){
            $_SESSION['isLoggedIn'] = array("person_id" => $login['person_id'],
                                            "login_time" => date("Y-m-d H:i:s")
                                           );
            PersonModel::redirect("index.php");
          }
          else{
            //print "LOGIN FAILED! <BR/> Please check your login details!";
            $messages["main"] = "Invalid email address or password!";
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
