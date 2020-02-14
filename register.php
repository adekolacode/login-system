<?php
session_start();
require_once 'config.php';
require_once 'dbh.php';
require_once 'functions.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
if (isset($_POST['register']))
{

$fname=$conn->real_escape_string(clean_input($_POST['firstname']));
$lname=$conn->real_escape_string(clean_input($_POST['lastname']));
$email=$conn->real_escape_string(clean_input($_POST['email']));
$password=$conn->real_escape_string(clean_input($_POST['password']));
$password=password_hash($password, PASSWORD_DEFAULT);
$vcode=substr(md5(uniqid(rand(), true)), 16, 10);

if (check() === 0){

$sql="INSERT INTO users (fname,lname,email,password,vcode) VALUES ('$fname','$lname','$email','$password','$vcode')";
$conn->query($sql);
$fullname=$fname.' '.$lname;
$id= $conn->insert_id;
$mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               
$mail->isSMTP();                                      
$mail->Host = MAILHOST;  
$mail->SMTPAuth = true;                           
$mail->Username = EMAIL;       
$mail->Password = SECRET;               
$mail->SMTPSecure = MAILSECURE;                       
$mail->Port = MAILPORT;                                 

$mail->setFrom(EMAIL, 'Techdekola');
$mail->addAddress($email,$fullname);   
$mail->addReplyTo(EMAIL, 'Techdekola');
$mail->isHTML(true);                                  

$mail->Subject = 'A verification link';
$mail->Body    = 'Click on the link to verify your account <a href="http://localhost/login-system/verify.php?v={$vcode}&id={$id}">click here</a>';
$mail->send();
$_SESSION['id']=$id;
header('location:index.php');
}
else{
    $error='User already exists';
}


}

?>





<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <?php if( isset($error)): ?>
                                            <div class='alert alert-danger text-center'><?php echo $error; ?></div>
                                        <?php  endif;  ?>
                                        <form id="register" action="register.php" method="POST">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="firstname">First Name</label><input class="form-control py-4" id="firstname" name="firstname" type="text" placeholder="Enter your first name" /></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="lastname">Last Name</label><input class="form-control py-4" id="lastname" name="lastname" type="text" placeholder="Enter your last name" /></div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="small mb-1" for="email">Email</label><input class="form-control py-4" id="email" type="email" name="email" placeholder="Enter email address" /></div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="password">Password</label><input class="form-control py-4" id="password" name="password" type="password" placeholder="Enter password" /></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="confirm_password">Confirm Password</label><input class="form-control py-4" id="confirm_password" name="confirm_password" type="password" placeholder="Confirm password" /></div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <button class="btn btn-primary btn-block" name="register">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>               
    <script type="text/javascript">
        $(document).ready(function(){

                $( "#register" ).validate( {
                rules: {
                    firstname: "required",
                    lastname: "required",
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    email: "Please enter a valid email address",
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    confirm_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter match password"
                    }
                    
                },
                errorElement: "em",
                errorPlacement: function ( error, element ) {
                    // Add the `invalid-feedback` class to the error element
                    error.addClass( "invalid-feedback" );

                    if ( element.prop( "type" ) === "checkbox" ) {
                        error.insertAfter( element.next( "label" ) );
                    } else {
                        error.insertAfter( element );
                    }
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
                },
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
                }

            } );
               

        });
    </script>
</body>
</html>
