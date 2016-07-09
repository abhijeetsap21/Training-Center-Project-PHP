<?php
session_start();    //start session
require_once('Model/PersonModel.php');
if(isset($_SESSION['isLoggedIn'])){                                                         //IF USER IS LOGGED IN
    $person = json_decode(PersonModel::get($_SESSION['isLoggedIn']['person_id']), true);    //GET PERSON DETAILS
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>EpiTrainer | By Samved Vajpeyi</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>
    <body>
    <div class="container">
    <div class="header">
        <img src="images/logo.png" alt="EpiTrainer Logo" style="margin-left: 400px;" />
        <div class="main_title_header">
            <ul>
                <li><a id="li-home" class="active" href="index.php">Home</a></li>
                    
                    <!-----------------------------------------------------
                    //SHOW MENUS FOR TRAINER OR STUDENT ACCORDINGLY
                    //----------------------------------------------------->
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
                    <a href="profile.php?pid=<?=$_SESSION['isLoggedIn']['person_id']?>">My Profile</a>
                    <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
<?php    
}
else{
    //-------------------------------------------------------------------------------------
    //If user is not logged in, he will be redirected to Login page, unless he is on a page
    //accessible for public (Login, Profile, Team, Project)
    //------------------------------------------------------------------------------------>
    if((basename($_SERVER['PHP_SELF']) == 'login.php') || (basename($_SERVER['PHP_SELF']) == 'profile.php') || (basename($_SERVER['PHP_SELF']) == 'project.php') || (basename($_SERVER['PHP_SELF']) == 'team.php')){
        //Do nothing
    }
    else{
        PersonModel::redirect("login.php");     //redirect to login page
    }
?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>EpiTrainer | By Samved Vajpeyi</title>
    <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
    <div class="container">
    <div class="header">
        <img src="images/logo.png" alt="EpiTrainer Logo" style="margin-left: 400px;" />
        <div class="main_title_header">
            <ul>
                <li><a class="active" href="index.php">Home</a></li>
                <li style="float:right;background:brown;"><a href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
<?php    
}

?>
