<!--php ends-->
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Park Select</title>

	<!--Open Sans Font-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
	
	<!-- Font Awesome icon library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

 	<!--<link rel="stylesheet" type="text/css" href="css\bootstrap.css"> if wanted offline-->

	<!-- custom CSS Stylesheet -->	  
    <link rel="stylesheet" type="text/css" href="styles.css";>
</head>

<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();

$update = $_GET['update'];

#if (!isset($_SESSION['team'])) {
$_SESSION['team'] = $_GET['team'];
#}

if (isset($_SESSION['parkId'])) {
    unset($_SESSION['parkId']);
	unset($_SESSION['parkName']);
}

?>

<body>
    <div class='centerContent mt-5 mb-3'><h1>Select Park</h1></div>

    <div class="container centerContent">
    <div class="row">
        <div class="col mb-2 centerContent">
            <div class="card" style="width: 25rem;">
            <a href="scheduler.php?team=<?=$_SESSION['team']?>&id=1&update=<?=$update?>"><img class="card-img" src='images/moorepark.jpg' alt="Card image cap"></a>
            </div>
        </div> <!--col end-->

        <div class="col centerContent">
            <div class="card" style="width: 25rem;">
            <a href="scheduler.php?team=<?=$_SESSION['team']?>&id=2&update=<?=$update?>"><img class="card-img" src='images/ysc.jpg' alt="Card image cap"></a>
            </div>
        </div> <!--col end-->
    </div> <!--row end-->
</div> <!--container end-->
</div>

<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>