<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();
checkForTeams($db);

$id=$_GET["id"];
$teamIdentifier="";
$teamName ="";
$coachFirstName ="";
$coachLastName="";
$coachEmail="";
$ageGroup="";
$teamLocation="";


$res=mysqli_query($db, "select * from Team where teamId=$id");
while($row=mysqli_fetch_array($res)){

    $teamIdentifier=$row["teamIdentifier"];
    $teamName=$row["teamName"];
    $coachFirstName=$row["coachFirstName"];
    $coachLastName=$row["coachLastName"];
    $coachEmail=$row["coachEmail"];
    $ageGroup=$row["ageGroup"];
    $teamLocation=$row["teamLocation"];

}
?>

<!-- START OF HEADER -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Team Info</title>

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

<body>
    <h1 class='centerContent mt-4'>Team  Information</h1>
    <div class='centerContent'>
    <div class="text-left p-2 mt-2" >
    <span><?php echo $teamIdentifier?></span></br>
    <span>Team Name: <?php echo $teamName ?></span></br>
    <span>Coach Name: <?php echo $coachFirstName." ".$coachLastName ?></span></br>
    <span>Email: <a href = "mailto: <?php echo $coachEmail?>"><?php echo $coachEmail ?></a></span></br>
    <span>Age Group:  <?php echo $ageGroup ?></span></br>
    <span>Location:  <?php echo $teamLocation ?></span></br><br>
    <span>
        <a href="edit-team.php?id=<?php echo $id;?>"> <button type="button" class= "btn btn-success">Edit Team</button></a>
        <a href="view-teams.php"> <button type="button" class= "btn btn-primary">Return</button></a>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>