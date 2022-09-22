<?php
$db = new mysqli('localhost', 'Alex', 'P*ssword', 'cajun_rush_schedule');

#if no session, start an empty session
if (!isset($_SESSION)) { session_start(); }

#connect to cajun_rush_schedule database if password is correct
function is_password_correct ($name, $password, $db) {

    $name = $db->real_escape_string($name);
    $result = $db->query("SELECT password FROM admins WHERE username = '$name'");
    
    $rows = mysqli_fetch_assoc($result); 
    if ($rows) {
      foreach ($rows as $row) {
        $correct_password = $row;
        return $password === $correct_password; #returns true
      }

    } else {
      return FALSE;   # user not found
    }
  }

function ensure_logged_in() {
    if (!isset($_SESSION["name"])) {
      header("Location: login.php");
      exit();
    }
  }
?> 