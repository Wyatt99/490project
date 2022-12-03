<!DOCTYPE html>
<html lang="en-us">

<!-- START OF HEADER -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Schedule Practices</title>

	<!--Open Sans Font-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
	
 	<!--<link rel="stylesheet" type="text/css" href="css\bootstrap.css"> if wanted offline-->

	<!-- custom CSS Stylesheet -->	  
    <link rel="stylesheet" type="text/css" href="styles.css";>
</head>
<!-- END OF HEADER -->

<!-- PHP PORTION -->
<?php
#Database
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();
checkForTeams($db);

if(isset($_SESSION['team'])) {
    unset($_SESSION['team']);
}

$res= "SELECT * FROM team LEFT JOIN practice ON team.teamID = practice.teamId JOIN season s ON team.seasonId = s.seasonId and s.seasonStatus = 1";

#currently works with only showing teams who ARE scheduled already
if (isset($_POST['search'])){
    $searchTerm = $_POST['search_box'];
    $res .= " WHERE teamIdentifier = '{$searchTerm}' ";
    $res .= " OR teamName = '{$searchTerm}' ";
    $res .= " OR coachFirstName = '{$searchTerm}'";
    $res .= " OR coachLastName = '{$searchTerm}'";
    $res .= " OR coachEmail = '{$searchTerm}'";
    $res .= " OR ageGroup = '{$searchTerm}'";
    $res .= " OR teamLocation = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, '', coachLastName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, ' ', coachLastName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachLastName, '', coachFirstName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachLastName, ' ', coachFirstName) = '{$searchTerm}'";
    
} else {
    $searchTerm = '';
}

$query=mysqli_query($db, $res);

function outputTable($query){
    while($row=mysqli_fetch_array($query)){
        if (!$row["teamId"]){ #if teamId NOT found in practice database on join, display results
        echo "<tr>";
        echo  "<td>"; echo $row["teamIdentifier"]."</td>";
        echo  "<td>"; ?> <a href="parkselect.php?team=<?php echo $row["teamIdentifier"];?>&update=0"> <button type="button" class= "btn btn-sm btn-success">Schedule</button></a> <?php echo "</td>"; #update team
        echo"</tr>";
        }
      }
}

if (isset($_POST['showAll'])){
    ?>
        <script type="text/javascript">
        window.location="team-select.php";
        </script>
    <?php
    }
?>

<!-- END OF PHP PORTION-->

<!-- START OF BODY -->
<body>
<h5 class="text-center" style="color: rgb(31, 107, 214); margin-bottom: -15px; margin-top: 15px;">Active Season: <?=getActiveSeason($db)?></h5>
<h1 class="centerContent mt-4 mb-3">Unscheduled Teams</h1>
<div class="text-center p-2 mb-2" >
<form name="search_form" method="POST" action="team-select.php">
    Search: <input type="text" class='mb-2 mb-md-0' name="search_box" placeholder="Search..." value="<?=$searchTerm?>" />
    <br class="d-md-none">
<input type="submit" name="search" value="Filter">
<input type="submit" name="showAll" value="Show All">
</form>
</div>


<?=$promptMessage($db)
?>
<table class="table table-bordered table-hover mt-1 centerContent smallFont">

    <thead>
    <tbody>
      <tr class='table-head'>
        <th>Team</th>
        <th>Schedule</th>
      </tr>
      </thead>
      <?=outputTable($query)?>
  
</tbody>

</table>
    

<?php
if (isset($_POST['addAnnounButton'])){

    if($db === false){
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }
    $announcement= mysqli_real_escape_string(
        $db, $_REQUEST['announcement']);
   
    
    $sql = "INSERT INTO announcements (announcement)
        VALUES ('$announcement')";

        # attempts the sql insert, if it fails the uniqueError is set
        if(mysqli_query($db, $sql)){
            $message="Announcement has been added!";
            echo "<div class='alert alert-success mt-3' role='alert'>".$message."</div>";
        } else {
            if(mysqli_errno($db) == 1062) {
            $message = "This Announcement already exists.";
            echo "<div class='alert alert-danger mt-3' role='alert'>".$message."</div>";
            }
        }
}
   
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>