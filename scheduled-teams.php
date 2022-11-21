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


$res = "Select t.*, p.*, f.*, pa.*, s.* FROM team t 
JOIN practice p ON t.teamId = p.teamId 
JOIN field f ON f.fieldId = p.fieldId 
JOIN park pa ON pa.parkId = f.parkId 
JOIN season s ON t.seasonId = s.seasonId and s.seasonStatus = 1";

if(isset($_POST['filter'])){
    $res = "Select t.*, p.*, f.*, pa.*, s.* FROM team t 
    JOIN practice p ON t.teamId = p.teamId 
    JOIN field f ON f.fieldId = p.fieldId 
    JOIN park pa ON pa.parkId = f.parkId 
    JOIN season s ON t.seasonId = s.seasonId and s.seasonStatus = 1";

    $group = $_POST['groupSelect'];
    $location = $_POST['locationSelect'];
    
    if($group != "1"){
        $res.=" AND ageGroup = {$group}";
    }

    if($location !="AA"){
        $res.=" AND teamLocation = '{$location}'";
    }
    $res.=" ORDER BY ageGroup, teamLocation";
}

if (isset($_POST['search'])){
    $res = "Select t.*, p.*, f.*, pa.*, s.* FROM team t 
    JOIN practice p ON t.teamId = p.teamId 
    JOIN field f ON f.fieldId = p.fieldId 
    JOIN park pa ON pa.parkId = f.parkId 
    JOIN season s ON t.seasonId = s.seasonId and s.seasonStatus = 1 ";

    $searchTerm = $_POST['search_box'];

    #create time from searchTerm (MUST be followed by AM or PM)
    $time = date("G:i a", strtotime($searchTerm));
    

    #team info search
    $res .= "WHERE teamIdentifier LIKE '{$searchTerm}%' ";
    $res .= " OR coachFirstName LIKE '{$searchTerm}%'";
    $res .= " OR coachLastName LIKE '{$searchTerm}%'";
    $res .= " OR coachEmail = '{$searchTerm}'"; #maybe not worth including, just requiring exact match for now
    $res .= " OR ageGroup = '{$searchTerm}'";
    $res .= " OR teamName LIKE '{$searchTerm}%'";
    $res .= " OR teamLocation = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, coachLastName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, ' ', coachLastName) = '{$searchTerm}'";

    #practice info search
    $res .= " OR day LIKE '{$searchTerm}%'";
    $res .= " OR fieldSection = '{$searchTerm}'"; #depending on what the sections are called can modify this if needed
    $res .= " OR fieldName = '{$searchTerm}'";
    $res .= " OR fieldName = CONCAT('field ', '{$searchTerm}')"; #an option so they dont have to type 'field ' when searching field name
    $res .= " OR parkName LIKE '{$searchTerm}%'";
    $res .= " OR startTime = '{$time}'";
    $res .= " OR endTime = '{$time}'";
} else {
    $searchTerm = '';
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
        
        $startTime = $time[0][4];
        $endTime = $time[0][5];
        $day = $time[0][6];
        
        $startTime = date("g:i a", strtotime($startTime));
        $endTime = date("g:i a", strtotime($endTime));
         
        $practiceTime = $startTime." - ".$endTime."<br><strong>".$day."</strong>";

        echo "<tr>";
        echo  "<td><div class='mb-1'>"; echo $row["teamIdentifier"]?></div><a href="parkselect.php?team=<?php echo $row["teamIdentifier"];?>&update=1"> 
        <button type="button" class= "btn btn-sm btn-success">Reschedule</button></a> 
        <a href="delete-practice.php?id=<?php echo $row["practiceId"]?> "onclick="return confirm('Are you sure you want to cancel the practice for <?php echo $row['teamIdentifier'] ?> scheduled at <?php echo date('g:i a', strtotime($row['startTime'])) ?> on <?php echo $row['day'] ?>?') ">
        <button type="button" class= "btn btn-sm btn-danger">Delete</button></a> <?php echo "</td>";
        echo "<td>".$practiceTime."</td>";
        echo "<td>".$parkName."<br>".$fieldName."<br>sect: ".$fieldSection."</td>";
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
<h1 class="centerContent my-3">Scheduled Teams</h1>
    <!-- search bar filter -->
    <div class="text-center  mb-1" >
    <form name="search_form" method="POST" action="scheduled-teams.php">
        Search: <input type="text" name="search_box" style="width:205px;" placeholder="Search..." value="<?=$searchTerm?>" />

        <input type="submit" name="search" value="Filter" style="margin-left:2px;">
    </form>
    </div>

    <div class="col-lg-12 p-2 ">
    <?=$promptMessage()?>
    
    <!--drop down form-->
    <div class="centerContent mb-2">
    <form name="team filter form" method="POST" action="scheduled-teams.php">

        <!-- Age Group Select Start -->
        <?php $result = $db->query("select ageGroup from agegroup");?>
        <select name='groupSelect' style="margin-left:55px;">

        <?php 
        if (isset($_POST['filter']) && ($group != "1")){?>
            <option value="<?=$group?>"><?=$group."u"?></option>
        <?php 
        }
        ?>
        <option value='1'>All Ages</option>

        <?php
        while ($row = $result->fetch_assoc()) {
            $id = $row['ageGroup'];
            echo "<option value='$id'>".$id."u</option>";
        }
        ?>
        </select>
        <!-- Age Group Select End -->
        
        <!-- Location Select Start -->
        <?php $result = $db->query("select teamLocation from teamlocation");?>
        <select name='locationSelect' style="margin-left:2px;">

        <?php 
        if (isset($_POST['filter']) && ($location != "AA")){?>
            <option value="<?=$location?>"><?=$location?></option>
        <?php 
        }
        ?>
        <option value='AA'>All Locations</option>

        <?php
        while ($row = $result->fetch_assoc()) {
            $id = $row['teamLocation'];
            echo "<option value='$id'>$id</option>";
        }
        ?>
        </select>
        <!-- Location Select End -->

        <input type="submit" name="filter" value="Filter" style="margin-left:5px;">
    </div>    

    <div class="centerContent mb-3">
        <input type="submit" name="showAll" value="Show All" style="width:200px;">
     </div>
    </form>
    <!--drop down form end -->

    <table class="table table-bordered table-hover px-1 mt-2 centerContent smallFont">
        <thead>
        <tbody>
        <tr class='table-head px-2'>
            <th>Team</th>
            <th>Time</th>
            <th>Location</th>
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