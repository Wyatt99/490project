<!DOCTYPE html>
<html lang="en-us">

<!-- START OF HEADER -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Select Team</title>

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

if(isset($_SESSION['team'])) {
    unset($_SESSION['team']);
}

$res= "SELECT * FROM team LEFT JOIN practice ON team.teamID = practice.teamId";

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
    
}

$query=mysqli_query($db, $res);

function outputTable($query){
    while($row=mysqli_fetch_array($query)){
        if (!$row["teamId"]){ #if teamId NOT found in practice database on join, display results
        echo "<tr>";
        echo  "<td>"; echo $row["teamIdentifier"]."</td>";
        echo  "<td>"; ?> <a href="parkselect.php?team=<?php echo $row["teamIdentifier"];?>&update=0"> <button type="button" class= "btn btn-success">Schedule</button></a> <?php echo "</td>"; #update team
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
<div class="text-center p-2 mt-4" >
<form name="search_form" method="POST" action="team-select.php">
    Search: <input type="text" name="search_box" value="" />
<input type="submit" name="search" value="Filter">
<input type="submit" name="showAll" value="Show All">
</form>
</div>

<div class="col-lg-12 p-2 ">
<?=$promptMessage()
?>

<h4 class="centerContent mt-3">Unscheduled Teams</h4>
<table class="table table-bordered mx-lg-2 centerContent">
<tbody>
    <thead>
      <tr>
        <th>Team</th>
        <th>Schedule</th>
      </tr>
      <?=outputTable($query)?>
    </thead>
</tbody>

</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>