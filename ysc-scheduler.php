<?php 
include 'db.php'; //connect to database
include 'admin-nav.php';
ensure_logged_in();

const parkID = 2;
const parkName = "Youngsville Sports Complex";


?>
<!--php ends-->

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>YSC Scheduler</title>

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

<body>
	<h1 class="mt-4 mb-2 text-lg-start text-center">Youngsville Sports Complex</h1>
	<h3 class="subText text-lg-start text-center">Practice Scheduler</h3>

	<form method="post" class="registerForm">
		<div class='row'>
			<div class='col-lg-6 col-sm-12'> <!--display 2 columns on md and up, 1 column on small-->

			</div>
		</div>
	</form>
	
</div>
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>