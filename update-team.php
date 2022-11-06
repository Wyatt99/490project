<!DOCTYPE html>
<html lang="en-us">

<!-- START OF HEADER -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update Team</title>

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

$res= "Select * from Team ";

if (isset($_POST['search'])){
    $searchTerm = $_POST['search_box'];

    $res .= "WHERE teamName LIKE '{$searchTerm}%'";
    $res .= " OR coachFirstName LIKE '{$searchTerm}%'";
    $res .= " OR coachLastName LIKE '{$searchTerm}%'";
    $res .= " OR coachEmail LIKE '{$searchTerm}%'";
    $res .= " OR ageGroup LIKE '{$searchTerm}%'";
    $res .= " OR teamLocation LIKE '{$searchTerm}%'";
    $res .= " OR CONCAT(coachFirstName, '', coachLastName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, ' ', coachLastName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachLastName, '', coachFirstName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachLastName, ' ', coachFirstName) = '{$searchTerm}'";
}
$query=mysqli_query($db, $res);

function outputTable($query){
    while($row=mysqli_fetch_array($query)){
        echo "<tr>";
        echo  "<td>"; echo $row["teamIdentifier"]."</td>";
        echo  "<td>"; ?> <a href="edit-team.php?id=<?php echo $row["teamId"];?>"> <button type="button" class= "btn btn-sm btn-success ">Edit</button></a> <?php echo "</td>"; #update team
        echo  "<td>"; ?> <a href="delete-team.php?id=<?php echo $row["teamId"] ?> "onclick="return confirm('Are you sure you want to delete <?php echo $row['teamIdentifier'] ?>?') ">
        <button type="button" class= "btn btn-sm btn-danger">Delete</button></a> <?php echo "</td>"; #delete team
        echo"</tr>";
      }
}
?>
<?php
if (isset($_POST['showAll'])){
?>
    <script type="text/javascript">
    window.location="update-team.php";
    </script>
<?php
}
?>
<!-- END OF PHP PORTION-->

<!-- START OF BODY -->
<body>

<h1 class='centerContent mt-4'>Edit Teams</h1>
<div class="text-center mt-2" >
<form name="search_form" method="POST" action="update-team.php">
Search: <input type="text" class='mb-2' name="search_box" value="" />
<br class="d-md-none">
<input type="submit" name="search" value="Filter">
<input type="submit" name="showAll" value="Show All">
</form>
</div>

<div class="mt-2">
<?=$promptMessage()?>
<table class="table table-bordered table-hover centerContent smallFont mt-2">

    <thead>
    <tbody>
      <tr class='table-head'>
        <th scope="col">Team</th>
        <th class="text-center" scope="col">Edit</th>
        <th class="text-center" scope="col">Delete</th>
      </tr>
      </thead>
  
      <?=outputTable($query)?>
    </tbody>

</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>

