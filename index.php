<?php 
session_start();
require_once 'config.php';
require_once 'dbh.php';
require_once 'functions.php';

if (empty($_SESSION)){
	header("location:login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<header class="text-center alert-dark"><b>Your dashboard</b><a href="logout.php" class="ml-2">Click to logout</a></header>
		<?php $id=$_SESSION['id']; ?>
			<?php if(checkverify() === false) : ?>
				<div class="alert alert-info mt-2 text-center">
					<?php echo "Please verify your account by checking your mail inbox or spam folder"; ?>
				</div>
			<?php endif; ?>
		<?php if(isset($_SESSION['message'])):?>
				<div class="alert alert-success text-center">
					<?php 
					echo $_SESSION['message']; 
					unset($_SESSION['message']);
					?>
						
				</div>
		<?php endif; ?>
</div>
</body>
</html>