<?php
$db = new mysqli('localhost', 'root', '', 'cajun_rush_schedule');

#if no session, start an empty session
if (!isset($_SESSION)) { session_start(); }

#connect to cajun_rush_schedule database if password is correct
function is_password_correct ($name, $password, $db) {
    $inputName = ($name);
    $result = $db->query("SELECT password FROM admins WHERE username = '$inputName'");
    $rows = mysqli_fetch_assoc($result); 
    if ($rows) {
      foreach ($rows as $hash) {
        return password_verify($password, $hash); #returns true
      }

    } else {
      return FALSE;   # user not found
    }
  }

#if $_SESSION['name'] is not set, redirect to login page
function ensure_logged_in() {
    if (!isset($_SESSION["name"])) {
      header("Location: login.php");
      exit();
    }
  }

#message to display if login credentials do not match database, password does not match, or registration is successful
$promptMessage = function() {
  if (isset($_GET['err'])) {
      $message = "Invalid credentials, please try again.";
      echo "<div class='alert alert-danger mt-3' role='alert'>".$message."</div>";
  }
  if (isset($_GET['errp'])) {
      $message = "Passwords do not match.";
      echo "<div class='alert alert-danger mt-3' role='alert'>".$message."</div>";
  }

  if (isset($_GET['newAdminSuccess'])) {
      $message = "Registered new admin successfully!";
      echo "<div class='alert alert-success mt-3' role='alert'>".$message."</div>";
  }
}
?> 