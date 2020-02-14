<?php
session_start();
require_once 'config.php';
require_once 'dbh.php';
require_once 'functions.php';

if (isset($_GET['id']) && isset($_GET['v'])){
	$id=$_GET['id'];
	$v=$_GET['v'];
	if (checkverify()===false){

		$vsql="SELECT * FROM users WHERE vcode='$v'";
		$vquery=$conn->query($vsql);
		$vrs=$vquery->fetch_assoc();
		$vid=$vrs['id'];
		if ($id == $vid){
			$vaccount="UPDATE users SET verify=1 WHERE id=$id";
			$conn->query($vaccount);
			$_SESSION['message']="You have successfully verified your account";
			$_SESSION['id']=$id;
			header("location:index.php");
			exit;
		}
		else{
			$message="Invalid verification link";
		}
	}
	else{
		$message="Account has already been verified";
}


}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Account Verification</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
		<div class="container">
			<?php if (isset($message)) : ?>
				<div class="alert alert-info text-center"><?php echo $message; ?></div>
			<?php endif;  ?>
		</div>
</body>
</html>