<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();

#if(isset($_POST['filter'])){}

$sql = "SELECT teamIdentifier, coachFirstName, coachLastName, team.seasonId as teamSeason FROM team, season 
    WHERE team.seasonId = season.seasonId AND seasonStatus = 1 ORDER BY ageGroup, teamLocation";
$query = mysqli_query($db, $sql);

function printTable($query){
    while($row=mysqli_fetch_array($query)){
        echo "<tr>";
        echo  "<td>"; echo $row["teamIdentifier"]."</td>";
        $coachName = $row["coachFirstName"]." ".$row["coachLastName"];
        echo  "<td>"; echo $coachName."</td>";
        echo  "<td>"; echo $row["teamSeason"]."</td>";
        echo"</tr>";
    }
}
?>

<!-- START OF HEADER -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Teams</title>

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

<!-- START OF BODY -->
<body>
    <h1 class='centerContent mt-4'>View Teams</h1>
    <div class="text-center p-2 mt-2" >
    <form name="team filter form" method="POST" action="view-teams.php">
        <input type="checkbox" id="inactive" name="inactive" value="0">
        <label for="inactive"> Show Inactive</label>

        <select name='groupSelect'>
        <option value='1'>All Ages</option>
        <option value='5'>5u</option>
        <option value='6'>6u</option>
        <option value='7'>7u</option>
        <option value='8'>8u</option>
        <option value='9'>9u</option>
        <option value='10'>10u</option>
        </select>

        <select name='parkSelect'>
        <option value='2'>All Parks</option>
        <option value='1'>Moore Park</option>
        <option value='2'>Youngsville</option>
        </select>

        <input type="submit" name="filter" value="Filter">
    </form>
    <div class="col-lg-12 p-2">
    <table class="table table-bordered mx-lg-2 centerContent text-center">
        <tbody>
            <thead>
            <tr>
                <th>Team</th>
                <th>Coach</th>
                <th>Season</th>
            </tr>
            <?=printTable($query)?>
            </thead>
        </tbody>
    </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>