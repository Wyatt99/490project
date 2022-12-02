<!DOCTYPE html>
<html lang="en-us">

<!-- START OF HEADER -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Admin</title>

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

<!-- START OF PHP-->
<?php
#Database
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();

$name=$_SESSION['name'];
$username = '';
$id = '';



$res=mysqli_query($db, "select * from Admins where username = '$name'");
while($row=mysqli_fetch_array($res)){
    $username=$row["username"];
    $id=$row['adminId'];
}
?>

<?php
if (isset($_POST["Update"])){
    $username = $_POST['username'];
    $res = $db->query("SELECT username FROM admins WHERE username = '$username'");
    $rows = mysqli_fetch_assoc($res);
    if(!$rows){
        $sql = "Update Admins set username ='$username' WHERE username = '$name'";
        mysqli_query($db, $sql);
        $_SESSION["name"] = $_POST['username'];
        ?>
        <script type="text/javascript">
        window.location="edit-admin.php?updateAdminSuccess";
        </script>
        <?php
    } 
    else {
        ?>
        <script type="text/javascript">
        window.location="edit-admin.php?duplicateAdmin";
        </script>
        <?php  
    }
    
}

if (isset($_POST["changePassword"])){
        ?>
        <script type="text/javascript">
        window.location="change-pass.php";
        </script>
        <?php  
}
?>
<!-- END OF PHP -->

<!-- START OF BODY -->
<body>
<div class="container mt-3 centerContent">
<div class="col-lg-4">

  <form action="" name = "form1" method = "post">
  <h1 class="centerContent mt-2">Account Info</h1>
  <?=$promptMessage($db)?>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" placeholder="Admin Username" name="username" value="<?=$username?>">
    </div>
    <div class="mt-1" style="display:flex; justify-content:flex-end; width:100%; padding:0;" >
    <button type="submit" name="Update" class="btn btn-primary mb-1 mb-lg-0 mt-2">Update</button>
    </div>

    <div class="centerContent mt-1">
    <button type="submit" name="changePassword" class="btn btn-secondary btn-lg mb-1 mt-3 mb-lg-0">Change Password</button>
    </div>

    <?php
        $idCheckQ=mysqli_query($db, "select adminId from Admins where username = '$name'");
        $idCheck=mysqli_fetch_assoc($idCheckQ);

        if ($idCheck['adminId'] == 1) {
          $adminsQ = mysqli_query($db, "SELECT * FROM admins WHERE adminId != 1");
          $adminExists = mysqli_fetch_all($adminsQ);
          if ($adminExists) {
          $adminsQ = mysqli_query($db, "SELECT * FROM admins WHERE adminId != 1");
          echo " <h2 class='centerContent mt-4 deleteAdmin'>Delete Admins</h2>
                <table class='table table-bordered table-hover px-1 mt-3 centerContent'>
                 <thead>
                 <tbody>
                 <tr class='table-head'>
                 <th scope='col' style='width:200px';>Admin</th>
                 <th class='text-center' scope='col'>Delete</th>
               </tr>
               </thead>";

          while($row=mysqli_fetch_array($adminsQ)){
            $username=$row["username"];
            $id=$row['adminId'];
            echo "<tr>";
            echo  "<td>"; echo $username."</td>";
            echo  "<td>"; ?> <a href="delete-admin.php?id=<?php echo $id ?>&user=1"onclick="return confirm('Are you sure you want to delete <?php echo $username ?>? This cannot be undone.') ">
            <button type="button" class= "btn btn-sm btn-danger">Delete</button></a> <?php echo "</td>"; 
            echo"</tr>";
        }
        echo "</table>";
        }
      }

        else { 
        echo 
        "<div class='centerContent mb-2 mt-3'>";
        echo  "<td>"; ?> <a href="delete-admin.php?id=<?php echo $id ?>&user=0" 
                          onclick="return confirm('Are you sure you want to delete your account? This cannot be undone') ">
        <button type="button" class= "btn btn-lg btn-danger">Delete Your Account</button></a> <?php echo "</td>"; 
        echo"</div>";
      }
  ?>

  </form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent editFooter">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>
