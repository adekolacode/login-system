<?php

function clean_input($data) {
 	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
}
function check(){
global $conn,$email;
$checksql="SELECT * FROM users WHERE email='$email'";
$checkquery=$conn->query($checksql);
$rs=$checkquery->num_rows;
return $rs;
}

function checkverify(){
global $conn,$id;
$checksql="SELECT * FROM users WHERE id='$id'";
$checkquery=$conn->query($checksql);
$rs=$checkquery->fetch_assoc();
$verifystatus=$rs['verify'];
if ($verifystatus == 0){
	return false;
}
else{
	return true;
}
}
















?>