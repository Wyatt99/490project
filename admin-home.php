<?php 
include 'head.php';
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();

?>
<body>
<h1>Hello <?= $_SESSION["name"] ?>, welcome back!</h1> <!--to confirm session created, will remove/edit later-->




<!-- Body ends -->
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>