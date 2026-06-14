<?php
    require __DIR__ . '/../utility.php';
    session_start();

    // this place still needs cookie checking but thas for later

    if (isset($_POST['btnLogin'])) {
        if (!emailCheck($_POST['email']))
            $message = 'Email is in an incorrect format';
        else {
            $sqlcon = new mysqli("localhost","root","","parkingdb");
            if ($sqlcon -> connect_error) die("Connection Failed");

            $submittedEmail = $_POST['email'];
            $submittedPass = $_POST['password']; 

            $sqlquery = "SELECT * FROM accounts WHERE email='$submittedEmail'";
            $sqlresult = $sqlcon -> query($sqlquery);

            if ($sqlresult -> num_rows > 0) {
                while ($row = $sqlresult -> fetch_assoc()) {
                    if ($submittedPass == $row['password']) {
                        if (isset($_POST['rememberMe']) and $_POST['rememberMe']) {
                            setcookie("loggedEmail", $submittedEmail, time() + 86400, "/");
                            setcookie("loggedPassword", $submittedPass, time() + 86400, "/");
                        }

                        header("Location: Dashboard.php");
                        exit();
                    }
                    else $message = "Incorrect Email or Password";
                }
            } else $message = "Incorrect Email or Password";


        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Park-It</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-image: linear-gradient(to bottom, #F86594, #FFCAA6);">
    <div class="container-fluid min-vh-100">
        <div class="row">
            <div class="col-7 d-flex align-items-start justify-content-center flex-column min-vh-100" style="padding-left: 8rem">
                <img src="../Assets/logo.png">
                <p style="font-size: 1.5rem; color: white;">Your easy to understand and easy to use parking management solution.</p>
            </div>
            <div class="col-5 d-flex align-items-center min-vh-100" style="padding-right: 8rem">
                <div class="container-box container p-5" style="border-radius: 1.5rem; width: 25rem;">
                    <div class="row">
                        <div class="col d-flex justify-content-center" style="font-size:1.3rem;">
                            <b>Employee Login</b>
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
                            <form method="POST" action="Login.php" class="d-flex flex-column justify-content-center gap-3">
                                <input type="email" name="email" class="form-control bg-body-secondary border-0" placeholder="Email" required>
                                <input type="password" name="password" class="form-control bg-body-secondary border-0" placeholder="Password" required >
                                <div>
                                    <input type="checkbox" name="rememberMe" value=true><label for="rememberMe">&nbsp;&nbsp;Remember Me</label><br>
                                </div>
                                <button type="submit" name="btnLogin" class="btn btn-primary" id="main-btn"> Proceed </button>
                            </form>
                            <?php
                                if(isset($message) or !empty($message))
                                    echo "<div class='text-danger text-center mt-3'>$message</div>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>