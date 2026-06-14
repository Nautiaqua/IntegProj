<?php
    session_start();

    if (isset($_COOKIE['loggedEmail']) && isset($_COOKIE['loggedPassword'])) {
        if (str_contains($_COOKIE['loggedEmail'], "@cloudtravels.ph")) {
            header("Location: resumeview.php");
            exit();
        }
    }

    if (!isset($_SESSION['currentEmail'])) {
        header("Location: index.php");
        exit();
    }

    function upFile(string $filePath, string $fileVar, bool $isImage) {
        if ($isImage) $targetFile = $filePath . $_SESSION['currentEmail'] . ".jpg";
        else {
            if (str_contains(basename($_FILES[$fileVar]["name"]), '.pdf')) 
                $targetFile = $filePath . $_SESSION['currentEmail'] . ".pdf";
            else 
                $targetFile = $filePath . $_SESSION['currentEmail'] . ".docx";
        };

        if ($_FILES[$fileVar]["error"] !== UPLOAD_ERR_OK) die("Error Uploading File");
        
        move_uploaded_file($_FILES[$fileVar]["tmp_name"], $targetFile);
    };

    upFile("Resume/Images/", 'apPhoto', true);
    upFile("Resume/Files/", 'apFile', false);


    if (str_contains(basename($_FILES['apFile']["name"]), '.pdf')) 
        $resumeFileName = $_SESSION['currentEmail'] . ".pdf";
    else 
        $resumeFileName = $_SESSION['currentEmail'] . ".docx";

    $applicantData = "Resume/Images/" . $_SESSION['currentEmail'] . ".jpg" . "\n";
    $applicantData .= $_POST['apFName'] . " " . $_POST['apLName'] . "\n";
    $applicantData .= $_SESSION['currentEmail'] . "\n";
    $applicantData .= $_POST['apAge'] . "\n";
    $applicantData .= $_POST['apPos'] . "\n";
    $applicantData .= "Resume/Files/" . $resumeFileName;

    file_put_contents('Resume/Details/' . $_SESSION['currentEmail'] . '.txt', $applicantData);
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
        <div class="container text-center p-4" id="mainlogin" style="width: 30rem; border-radius: 1.6rem;">
            <h1><b>Application Submitted!</b></h1>
            <br>
            <img src="Assets/check-mark.png" style="width: 256px; height: 256px;">
            <br>
            <p class="mt-3">Hi <b><?php echo $_SESSION['currentEmail']; ?></b> your resume has been successfully submitted.</p>
            <p>We'll be in touch soon. You may now close this page.</p>
            <br>
            <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>