<?php
session_start();

if (!isset($_SESSION['currentEmail'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    @mkdir("Resume/Data",   0777, true);
    @mkdir("Resume/Images", 0777, true);
    @mkdir("Resume/Files",  0777, true);

    $name           = $_POST['apFName'] . " " . $_POST['apLName'];
    $age            = $_POST['apAge'];
    $position       = $_POST['apPos'];
    $imageFileName  = basename($_FILES["apPhoto"]["name"]);
    $resumeFileName = basename($_FILES["apFile"]["name"]);

    $applicantData = [
        "photo"       => "Resume/Images/" . $imageFileName,
        "name"        => $name,
        "email"       => $_SESSION['currentEmail'],
        "age"         => $age,
        "applyingfor" => $position,
        "resume_file" => "Resume/Files/" . $resumeFileName
    ];

    file_put_contents("Resume/Data/" . $name . ".json", json_encode($applicantData));

    if ($_FILES['apPhoto']["error"] !== UPLOAD_ERR_OK) die("Error Uploading Image");
    if (!move_uploaded_file($_FILES["apPhoto"]["tmp_name"], "Resume/Images/" . $imageFileName)) die("Failure w/ Uploading Image");

    if ($_FILES['apFile']["error"] !== UPLOAD_ERR_OK) die("Error Uploading Resume");
    if (!move_uploaded_file($_FILES["apFile"]["tmp_name"], "Resume/Files/" . $resumeFileName)) die("Failure w/ Uploading Resume");

    $_SESSION['applicant'] = $name;
}

if (!isset($_SESSION['applicant'])) {
    header("Location: apply.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CloudTravels Resume Portal</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body id="mainbody">
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
        <div class="text-center">
            <h1><b>Application Submitted!</b></h1>
            <br>
            <p class="mt-3">Hi <strong><?= htmlspecialchars($_SESSION['applicant']) ?></strong>, your resume has been successfully submitted.</p>
            <p>We'll be in touch soon. You may now close this page.</p>
            <br>
            <a href="emplogin.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>