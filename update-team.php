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

$res= "Select * from Team ";

if (isset($_POST['search'])){
	
    $searchTerm = $_POST['search_box'];

    $res .= "WHERE teamName = '{$searchTerm}' ";
    $res .= " OR coachFirstName = '{$searchTerm}'";
    $res .= " OR coachLastName = '{$searchTerm}'";
    $res .= " OR coachEmail = '{$searchTerm}'";
    $res .= " OR ageGroup = '{$searchTerm}'";
    $res .= " OR teamLocation = '{$searchTerm}'";
}
$query=mysqli_query($db, $res);

function outputTable($query){
    while($row=mysqli_fetch_array($query)){
        echo "<tr>";
        echo  "<td>"; echo $row["teamName"];  echo "</td>";
        echo  "<td>"; echo $row["coachFirstName"];  echo "</td>";
        echo  "<td>"; echo $row["coachLastName"];  echo "</td>";
        echo  "<td>"; echo $row["coachEmail"];  echo "</td>";
        echo  "<td>"; echo $row["ageGroup"];  echo "</td>";
        echo  "<td>"; echo $row["teamLocation"];echo "</td>";
        echo  "<td>"; ?> <a href="edit-team.php?id=<?php echo $row["teamId"];?>"> <button type="button" class= "btn btn-success">Edit</button></a> <?php echo "</td>"; #update team
        echo  "<td>"; ?> <a href="delete-team.php?id=<?php echo $row["teamId"];?>"> <button type="button" class= "btn btn-danger">Delete</button></a> <?php echo "</td>"; #delete team
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
<div class="text-center p-2" >
<form name="search_form" method="POST" action="update-team.php">
Search: <input type="text" name="search_box" value="" />

<input type="submit" name="search" value="Filter">
<input type="submit" name="showAll" value="Show All">
</form>
</div>

<div class="col-lg-12 p-2">
<?=$promptMessage()
?>
<table class="table table-bordered">
<tbody>
    <thead>
      <tr>
        <th>Team Name</th>
        <th>Coach First Name</th>
        <th>Coach Last Name</th>
        <th>Coach Email</th>
        <th>Age Group</th>
        <th>Team Location</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?=outputTable($query)?>
    </thead>
</tbody>

</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->

</html>

