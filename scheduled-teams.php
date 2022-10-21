<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Scheduled Teams</title>

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

$res= "Select * from team JOIN practice ON team.teamId = practice.teamId  ";

#currently works with only showing teams who ARE scheduled already
if (isset($_POST['search'])){
    $searchTerm = $_POST['search_box'];
    $res .= "WHERE teamIdentifier = '{$searchTerm}' ";
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

$searchQuery=mysqli_query($db, $res);
function outputTable($db,$searchQuery){
    while($row=mysqli_fetch_array($searchQuery)){
        $timeQuery = "SELECT * from practice WHERE teamId = $row[teamId]";
        $timeResult = $db->query($timeQuery);
        $time = mysqli_fetch_all($timeResult);
        
        $fieldId = $row['fieldId'];
        $fieldSection = $row['fieldSection'];
        $parkIdRes = "SELECT * FROM field WHERE fieldId=$fieldId";
        $parkIdQuery=mysqli_query($db, $parkIdRes);
        while($parkIdRow=mysqli_fetch_array($parkIdQuery)){
            $parkId = $parkIdRow['parkId'];
            $fieldName = $parkIdRow['fieldName'];
        }
        $parkNameRes= "SELECT parkName FROM park where parkId=$parkId";
        $parkNameQuery=mysqli_query($db, $parkNameRes);
        while($parkNameRow=mysqli_fetch_array($parkNameQuery)){
            $parkName = $parkNameRow['parkName'];
            if ($parkName == "Moore Park") {
                $parkName = "Moore";
            }
            else {
                $parkName = "YSC";
            }
        }
        
        #TODO: convert to 12 hour format
        $startTime = $time[0][4];
        $endTime = $time[0][5];
        $day = $time[0][6];
        $startTime = date("g:i a", strtotime($startTime));
        $endTime = date("g:i a", strtotime($endTime));
         
        $practiceTime = $startTime." - ".$endTime." &nbsp<strong>".$day."</strong>";

        echo "<tr>";
        echo  "<td>"; echo $row["teamIdentifier"]."</td>";
        echo "<td>".$practiceTime."</td>";
        echo "<td>".$parkName."</td>";
        echo "<td>".$fieldName."</td>";
        echo "<td>".$fieldSection."</td>";
        echo  "<td>"; ?> <a  href="parkselect.php?team=<?php echo $row["teamIdentifier"];?>&update=1"> <button type="button" class= "btn btn-success">Reschedule</button></a> <?php echo "</td>"; #update team
        echo"</tr>";
      }
}


if (isset($_POST['showAll'])){
    ?>
    <script type="text/javascript">
        window.location="scheduled-teams.php";
    </script>
    <?php
    }
?>
<!-- END OF PHP PORTION-->

<!-- START OF BODY -->
<body>
<h1 class="centerContent my-3">Currently Scheduled Teams</h1>
    <div class="text-center p-2 mb-2" >
    <form name="search_form" method="POST" action="scheduled-teams.php">
        Search: <input type="text" name="search_box" value="" />

        <input type="submit" name="search" value="Filter">
        <input type="submit" name="showAll" value="Show All">
    </form>
    </div>

    <div class="col-lg-12 p-2 ">
    <?=$promptMessage()?>

 
    <table class="table table-bordered mx-lg-2 centerContent">
    <tbody>
        <thead>
        <tr>
            <th>Team</th>
            <th>Time</th>
            <th>Park </th>
            <th>Field </th>
            <th>Sect.</th>
            <th class="text-center">Reschedule</th>
        </tr>
        <?=outputTable($db, $searchQuery)?>
        </thead>
    </tbody>

    </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>