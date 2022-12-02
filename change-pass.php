<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();

if (isset( $_POST['submit'] )) {
    $name = $_SESSION['name'];

    if(!is_password_correct($name, $_POST['currPass'], $db)){
        header("location: change-pass.php?errPassCheck");
        exit();
    }

    if($_POST['password'] != $_POST['password_confirm']){
        header("location: change-pass.php?errNewPassMatch");
        exit();
    }

    $match = preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $password);
    if ($match) {
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $registerPrep = $db -> prepare("UPDATE admins SET password = '$password_hash' where username = '$name'");
    $registerPrep -> execute();
    header("location: change-pass.php?newPassSet");
    exit();
    }
    else {
        header("location: change-pass.php?special");
    }
}
?> <!--php ends-->

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change Password</title>

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
    <img src="images\CajunRushLogo.png" class="mx-auto d-flex pt-5 pb-0" width="110px" height="auto" alt="cajun rush logo">
    <div class="d-flex justify-content-center mx-auto">

    <form method="post" class="registerForm">
        <h1 class="mt-2 mb-3 centerContent ">Change Password</h1>
        <?=$promptMessage()?> <!--call prompt message function-->

        <div class="password-container form-outline mb-2">
            <input type="password" name="currPass" id="currPass" class="form-control form-control-lg" minlength='8' required/>
            <i class="fa-solid fa-eye" id="eye3"></i>
            <label class="form-label" for="currPass">Current Password</label>
        </div>

        <div class="password-container form-outline mb-2">
            <input type="password" name="password" id="password" class="form-control form-control-lg" minlength='8' required/>
            <i class="fa-solid fa-eye" id="eye"></i>
            <label class="form-label" for="password">New Password</label>
        </div>

        <div class="password-container form-outline mb-2">
            <input type="password" name="password_confirm" id="password_confirm" class="form-control form-control-lg" minlength='8' required/>
            <i class="fa-solid fa-eye" id="eye2"></i>
            <label class="form-label" for="password_confirm">Confirm New Password</label>
        </div>

            <button class="btn-primary btn-lg btn-block" type="submit" name='submit' value='Login'>Submit</button>
            
        </form>
        
    </div>

    <script> 
        //select password field, password_confirm field, and currPass field
        const passwordField = document.querySelector("#password");
        const password_confirmField = document.querySelector("#password_confirm");
        const current_passwordField = document.querySelector("#currPass")
        //select eye icon (new password), eye2 icon (confirm), and eye3 icon (currpass)
        const eye= document.querySelector("#eye");
        const eye2= document.querySelector("#eye2");
        const eye3= document.querySelector("#eye3");

        //event listener to toggle class from 'fa-solid fa-eye'(solid eye) to 'fa-eye-slash'(eye with slash) on click, 
        //and update password 'type' attribute
        eye.addEventListener("click", function() {
        this.classList.toggle("fa-eye-slash");

        //set type constant as text if password, or password if text
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        
        //set 'type' attribute of password_confirm field to type constant assigned above  
        passwordField.setAttribute("type", type);
    })
        //event listener to toggle class from 'fa-solid fa-eye'(solid eye) to 'fa-eye-slash'(eye with slash) on click, 
        //and update password 'type' attribute
        eye2.addEventListener("click", function() {
        this.classList.toggle("fa-eye-slash");

        //set type constant as text if password, or password if text
        const type = password_confirmField.getAttribute("type") === "password" ? "text" : "password";  
        
        //set 'type' attribute of password_confirm field to type constant assigned above          
        password_confirmField.setAttribute("type", type);
    })
        //event listener to toggle class from 'fa-solid fa-eye'(solid eye) to 'fa-eye-slash'(eye with slash) on click, 
        //and update password 'type' attribute
        eye3.addEventListener("click", function() {
        this.classList.toggle("fa-eye-slash");

        //set type constant as text if password, or password if text
        const type = current_passwordField.getAttribute("type") === "password" ? "text" : "password";  
        
        //set 'type' attribute of password_confirm field to type constant assigned above          
        current_passwordField.setAttribute("type", type);
    })       
    </script>

	<!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>