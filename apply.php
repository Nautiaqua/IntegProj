<?php
    session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CloudTravels Resume Portal</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">

        <!-- bootstrap components -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body id="mainbody" data-bs-theme="light">
        <div class="container-fluid">
            <div id="mainlogin" class="container mt-4 p-5" style="border-radius: 1.6rem; width: 50rem;">
                <form method="post" action="complete.php">
                    <div class="row"><h3>Application</h3></div>
                    <div class="row">
                        <p>Please input your details and upload your resume.</p>
                    </div>
                    <div class="row d-flex justify-content-center"><hr style="width: 98%;"></div>
                    <div class="row">
                        <p><b>Uploading resume as: </b><?php echo $_SESSION['currentEmail']; ?></p>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="container d-flex flex-column gap-2">
                                First Name <input required type="text" name="apFName" class="form-control bg-body-secondary border-0" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="container d-flex flex-column gap-2">
                                Last Name <input required type="text" name="apLName" class="form-control bg-body-secondary border-0" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="container d-flex flex-column gap-2">
                                Age <input required type="number" name="apAge" class="form-control bg-body-secondary border-0" placeholder="Age">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row"> 
                        <div class="col-6">
                            <div class="container d-flex flex-column gap-2">
                                Photo (1x1) <input required type="file" name="apAge" accept=".jpg,.png" class="form-control bg-body-secondary border-0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="container d-flex flex-column gap-2">
                                Resume / CV (.pdf or .docx) <input required type="file" name="apAge" accept=".pdf,.docx" class="form-control bg-body-secondary border-0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- bootstrap json -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>