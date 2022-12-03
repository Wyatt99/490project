<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

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
include('db.php'); //connect to database

#if username and password are submitted, create variables
if (isset($_POST["name"]) && isset($_POST["password"])) {
    $name = $_POST["name"];
    $password = $_POST["password"];
    
#call function in db.php to validate the password
if (is_password_correct($name, $password, $db)) {
    #if existing session, destroy old and start new
    if (isset($_SESSION)) {
      session_destroy();
      session_regenerate_id(TRUE);
      session_start();
    }
    # if user and pass match, remember user info and redirect to home
    $_SESSION["name"] = $name;

    $idQuery = $db->query("SELECT adminId FROM admins WHERE username LIKE '$_SESSION[name]'");
	$idStmnt = mysqli_fetch_all($idQuery);
	$_SESSION["adminId"] = $idStmnt[0][0];     
    header("location: admin-home.php");
  }
  #else reload login page with error message
  else {
    header("location: login.php?err");
  }
}

?> 
<!--php ends-->
<body>
    <img src="images\CajunRushLogo.png" class="mx-auto d-flex pt-5 pb-0" width="110px" height="auto" alt="cajun rush logo">
    <div class="d-flex justify-content-center mx-auto">

    <form method="post">
    <h1 class="mt-4 mb-3 centerContent ">Admin Login</h1>
    <?=$promptMessage($db)?> <!--call prompt message function-->
        <div class="form-outline mb-2">
            <input type="text" name="name" id="name" class="form-control form-control-lg"/>
            <label class="form-label" for="name">Username</label>
        </div>

        <div class="password-container form-outline mb-2">
            <input type="password" name="password" id="password" class="form-control form-control-lg" />
            <i class="fa-solid fa-eye" id="eye"></i>
            <label class="form-label" for="password">Password</label>
        </div>
        <button class="btn-primary btn-lg btn-block mb-2" type="submit" name='submit' value='Login'>Login</button><br>

       
           
        <a href="index.php" style="display:block; text-decoration:none" class="mt-3">Return to user page</a>

        <a href="javascript:void(0);" id="forgot">Forgot username or password?</a>
        <div style="display: none;" class="alert alert-danger mt-2 mx-auto text-center" id="forgotText">
            Contact Cajun Rush director to recover credentials.
        </div>

    </form>
    </div>

    <script> 
        //select password field and eye icon(s)
        const passwordField = document.querySelector("#password");
        const eye= document.querySelector("#eye");
        
        eye.addEventListener("click", function() {
        //toggle class from 'fa-solid fa-eye'(solid eye) to 'fa-eye-slash' (eye with slash)
        this.classList.toggle("fa-eye-slash");

        //set type constant as text if password, or password if text
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";            
        passwordField.setAttribute("type", type);
    })
        var forgotDiv = document.getElementById("forgot");
        forgotDiv.addEventListener("click", forgotPassword);

        function forgotPassword() {
            var x = document.getElementById("forgotText");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
   
	<!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>