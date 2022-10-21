<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();
checkForTeams($db);

$sql = "SELECT teamId, teamIdentifier, coachFirstName, coachLastName, coachEmail, teamLocation, team.seasonId as teamSeason FROM team, season 
    WHERE team.seasonId = season.seasonId AND seasonStatus = 1 ORDER BY ageGroup, teamLocation";

if(isset($_POST['filter'])){
    $group = $_POST['groupSelect'];
    $location = $_POST['locationSelect'];
    $sql = "SELECT teamId, teamIdentifier, coachFirstName, coachLastName, coachEmail, teamLocation, team.seasonId as teamSeason FROM team, season WHERE
        team.seasonId = season.seasonId";

    if(isset($_POST['inactive'])){
        $sql.=" AND (seasonStatus = 0 OR seasonStatus = 1)";
    }else{
        $sql.=" AND seasonStatus = 1";
    }

    if($group != "1"){
        $sql.=" AND ageGroup = {$group}";
    }

    if($location !="AA"){
        $sql.=" AND teamLocation = '{$location}'";
    }

    $sql.=" ORDER BY ageGroup, teamLocation";
}

$query = mysqli_query($db, $sql);

function printTable($query){
    while($row=mysqli_fetch_array($query)){
        echo "<tr>";
        echo  "<td>"; 
        echo '<a href="team-info.php?id='.$row["teamId"].'">'.$row["teamIdentifier"].'</a>';
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

        <?php $result = $db->query("select ageGroup from agegroup");?>
        <select name='groupSelect'>
        <option value='1'>All Ages</option>
        <?php
        while ($row = $result->fetch_assoc()) {
            $id = $row['ageGroup'];
            echo "<option value='$id'>$id</option>";
        }
        ?>
        </select>
        
        <?php $result = $db->query("select teamLocation from teamlocation");?>
        <select name='locationSelect'>
        <option value='AA'>All Locations</option>
        <?php
        while ($row = $result->fetch_assoc()) {
            $id = $row['teamLocation'];
            echo "<option value='$id'>$id</option>";
        }
        ?>
        </select>

        <input type="submit" name="filter" value="Filter">
        <input type="submit" name="showAll" value="Show All">
    </form>

    <div class="col-lg-12 p-2">
    <table class="table table-bordered mx-lg-2 centerContent">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>