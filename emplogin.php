<?php
session_start();

$employees = array( "aj07@gmail.com" => "12345678", "aj09@gmail.com" => "password123", "aj10@gmail.com" => "password1234", "aj11@gmail.com" => "password12345" );
$message = "";
if(isset($_POST['btnLogin']))
{
    $inputEmail = $_POST['txtEmail'];
    $inputPassword = $_POST['txtPassword'];

    if(isset($employees[$inputEmail]) &&
       $employees[$inputEmail] == $inputPassword)
    {
        $_SESSION['employee'] = $inputEmail;

        header("Location: resumes.php");
        exit();
    }
    else
    {
        $message = "Invalid email or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>iSys Resume Portal</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">

        <!-- bootstrap components -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <style>
            body{
                background-color:#dfe7f3;
                font-family: 'Monserrat', sans-serif;
            }
            #mainlogin{
                background-color: white;
                box-shadow:0 4px 15px rgba(0,0,0,0.1);
            }
        </style>

    </head>
    <body data-bs-theme="light">
        <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">

    <div id="mainlogin" class="container p-5" style="border-radius: 1.5rem; width: 25rem;">

        <div class="row d-flex align-items-center justify-content-center">
            <img id="loginlogo" src="Assets/roundlogo.png" class="img-fluid" style="width: 5rem;">
        </div>

        <div class="row mt-4">
            <div class="col d-flex justify-content-center" style="font-size:1.3rem;">
                <b>Employee Portal</b>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            Please enter your Email and password.
        </div>

        <div class="row d-flex justify-content-center">
            <hr class="my-3" style="width:20rem;">
        </div>

        <div class="row">
            <div class="col">
                <form method="POST" class="d-flex flex-column justify-content-center gap-3">
                    <input type="email" name="txtEmail" class="form-control bg-body-secondary border-0" placeholder="Email" required >
                    <input type="password" name="txtPassword"  class="form-control bg-body-secondary border-0" placeholder="Password" required >
                    <button type="submit" name="btnLogin" class="btn btn-primary"> Proceed </button>
                </form>
                <?php
                if($message != "")
                {
                    echo "<div class='text-danger text-center mt-3'>$message</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

        <!-- bootstrap json -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>
