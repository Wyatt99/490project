<?php
#Database
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();

$id=$_GET["id"];

$teamName ="";
$coachFirstName ="";
$coachLastName="";
$coachEmail="";
$ageGroup="";
$teamLocation="";


$res=mysqli_query($db, "select * from Team where teamId=$id");
while($row=mysqli_fetch_array($res)){

    $teamName=$row["teamName"];
    $coachFirstName=$row["coachFirstName"];
    $coachLastName=$row["coachLastName"];
    $coachEmail=$row["coachEmail"];
    $ageGroup=$row["ageGroup"];
    $teamLocation=$row["teamLocation"];

}
?>

<?php
if (isset($_POST["Update"])){
    mysqli_query($db, "update Team set teamName ='$_POST[teamName]', coachFirstName ='$_POST[coachFirstName]', coachLastName ='$_POST[coachLastName]', coachEmail ='$_POST[coachEmail]', ageGroup ='$_POST[ageGroup]', teamLocation ='$_POST[teamLocation]' where teamId=$id");
    ?>
    <script type="text/javascript">
    window.location="update-team.php?updateteamsuccess";
    </script>
    <?php
    
}
    ?>

<?php
if (isset($_POST["Return"])){
    ?>
    <script type="text/javascript">
    window.location="update-team.php";
    </script>
    <?php
}
    ?>

<?php
if (isset($_POST["Refresh"])){
    ?>
    <script type="text/javascript">
    window.location="update-team.php?id"+$id;
    </script>
    <?php
}
    ?>




<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Team</title>

	<!--Open Sans Font-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
	
 	<!--<link rel="stylesheet" type="text/css" href="css\bootstrap.css"> if wanted offline-->

	<!-- custom CSS Stylesheet -->	  
    <link rel="stylesheet" type="text/css" href="styles.css";>
</head>

<!-- Create form -->
<body>

<div class="container mt-3">
<h3>Update Team</h3>
<div class="col-lg-4">

  <form action="" name = "form1" method = "post">
      
    <div class="form-group">
      <label for="teamName">Team Name</label>
      <input type="text" class="form-control" id="teamName" placeholder="Enter team name" name="teamName" value="<?=$teamName?>">
    </div>

    <div class="form-group">
      <label for="coachFirstName">Coach First Name</label>
      <input type="text" class="form-control" id="coachFirstName" placeholder="Enter first name" name="coachFirstName" value="<?=$coachFirstName?>">
    </div>

    <div class="form-group">
      <label for="coachLastName">Coach Last Name</label>
      <input type="text" class="form-control" id="coachLastName" placeholder="Enter last name" name="coachLastName" value="<?=$coachLastName?>">
    </div>

    <div class="form-group">
      <label for="coachEmail">Coach Email</label>
      <input type="email" class="form-control" id="coachEmail" placeholder="Enter email" name="coachEmail" value="<?=$coachEmail?>">
    </div>

    <div class="form-group">
      <label for="ageGroup">Age Group</label>
      <input type="text" class="form-control" id="ageGroup" placeholder="Enter age group" name="ageGroup" value="<?=$ageGroup?>">
    </div>

    <div class="form-group">
      <label for="teamLocation">Team Location</label>
      <input type="text" class="form-control" id="teamLocation" placeholder="Enter Location" name="teamLocation" value="<?=$teamLocation?>">
    </div>
    
    <div class="mt-3">
    <button type="submit" name="Update" class="btn btn-success">Update</button>
    <button type="submit" name="Return" class="btn btn-secondary">Return</button>
    </div>
  </form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
