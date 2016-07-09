<?php
class DB {

  /** Give a connection to the DB, in UTF-8 */
  public static function getConnection() {
    // DB configuration
    $db = "training_center";
    $dsn = "mysql:dbname=$db;host=localhost";
    $user = "trainer";
    $password = "nevermind";
    // Get a DB connection with PDO library
    $bdd = new PDO($dsn, $user, $password);
    // Set communication in utf-8
    $bdd->exec("SET character_set_client = 'utf8'");
    return $bdd;
  }
}
