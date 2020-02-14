<?php 
session_start();
require_once 'config.php';
require_once 'dbh.php';
require_once 'functions.php';

if (isset($_POST['login'])){

    $email=$conn->real_escape_string(clean_input($_POST['email']));
    $password=$conn->real_escape_string(clean_input($_POST['password']));
    $loginsql="SELECT * FROM users WHERE email='$email'";
    $loginquery=$conn->query($loginsql);
    $result=$loginquery->fetch_assoc();
    $pass=$result['password'];
    $userid=$result['id'];
if (check() > 0){
    if(password_verify($password,$pass)){
        $_SESSION['id']=$userid;
        header('location:index.php');

        }
        else{
            $error="Incorrect password";
        }
}
else{
    $error='User does not exist';
}
}




?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
                    <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-5">
                                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                        <div class="card-body">
                                            <?php if( isset($error)): ?>
                                                <div class='alert alert-danger text-center'><?php echo $error; ?></div>
                                            <?php  endif;  ?>
                                            <form id="login" action="login.php" method="POST">
                                                <div class="form-group"><label class="small mb-1" for="email">Email</label><input class="form-control py-4" id="email" type="email" name="email"placeholder="Enter email address" /></div>
                                                <div class="form-group"><label class="small mb-1" for="password">Password</label><input class="form-control py-4" id="password" type="password" name="password" placeholder="Enter password" /></div>
                                                <div class="form-group mt-4 mb-0 text-center">
                                                    <button class="btn btn-primary" name="login">Login</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>               
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $( "#login" ).validate( {
                rules: {
                    
                    email:{
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 5
                    }

                },
                messages: {
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    email: "Please enter a valid email address"
                },
                errorElement: "em",
                errorPlacement: function ( error, element ) {
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


             })       

        });
    </script>
</body>
</html>