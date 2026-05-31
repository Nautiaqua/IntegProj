<?php
    session_start();

    $name = $_POST['apFName'] . " " . $_POST['apLName'];
    $age = $_POST['apAge'];
    $position = $_POST['apPos'];
    $imageFileName = basename($_FILES["apPhoto"]["name"]);
    $resumeFileName = basename($_FILES["apFile"]["name"]);

    $applicantData = array(
        "photo"=>"Resume/Files" . $imageFileName,
        "name"=>$name,
        "email"=>$_SESSION['currentEmail'],
        "age"=>$age,
        "applyingfor"=>$position,
        "resume_file"=>"Resume/Files" . $resumeFileName
    );

    // uploads the json details
    $jsonDetails = json_encode($applicantData);
    

    // uploads the image
    $targetFile = "Resume/Images" . $imageFileName;
    
    if ($_FILES['apPhoto']["error"] !== UPLOAD_ERR_OK) die("Error Uploading File");

    if (move_uploaded_file($_FILES["apPhoto"]["tmp_name"], $targetFile)) {
        echo "Success w/ Uploading Image";
        return $targetFile;
    } 
    else echo "Success w/ Uploading Image";

    // uploads the resume file
    $targetFile2 = "Resume/Files" . $resumeFileName;
    
    if ($_FILES['apFile']["error"] !== UPLOAD_ERR_OK) die("Error Uploading File");

    if (move_uploaded_file($_FILES["apFile"]["tmp_name"], $targetFile2)) {
        echo "Success w/ Uploading Resume File";
    } 
    else echo "Failure w/ Uploading Resume File";
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CloudTravels Resume Portal</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">

        <!-- bootstrap components -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body data-bs-theme="light">
        <div class="container-fluid">
            <!-- content in here -->
        </div>

        <!-- bootstrap json -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>