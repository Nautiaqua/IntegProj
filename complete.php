<?php
    session_start();

    function upFile(string $filePath, string $fileVar, bool $isImage) {
        if ($isImage) $targetFile = $filePath . $_SESSION['currentEmail'] . ".jpg";
        else {
            if (str_contains(basename($_FILES[$fileVar]["name"]), '.pdf')) 
                $targetFile = $filePath . $_SESSION['currentEmail'] . ".pdf";
            else 
                $targetFile = $filePath . $_SESSION['currentEmail'] . ".docx";
        };

        if ($_FILES[$fileVar]["error"] !== UPLOAD_ERR_OK) die("Error Uploading File");


        // too lazy to change it so i just commented it out <3
        if (move_uploaded_file($_FILES[$fileVar]["tmp_name"], $targetFile)) {
            ;
            // echo "Success w/ Uploading Image:";
        } 
        else {
            ;
            // echo "Failure w/ Uploading Image";
        }
             
    };

    upFile("Resume/Images/", 'apPhoto', true);
    upFile("Resume/Files/", 'apFile', false);

    if (str_contains(basename($_FILES['apFile']["name"]), '.pdf')) 
        $resumeFileName = $_SESSION['currentEmail'] . ".pdf";
    else 
        $resumeFileName = $_SESSION['currentEmail'] . ".docx";

    $applicantData = array(
        "photo"=> "Resume/Images/" . $_SESSION['currentEmail'] . ".jpg",
        "name"=> $_POST['apFName'] . " " . $_POST['apLName'],
        "email"=> $_SESSION['currentEmail'],
        "age"=> $_POST['apAge'],
        "applyingfor"=> $_POST['apPos'],
        "resume_file"=> "Resume/Files/" . $resumeFileName
    );
    file_put_contents('Resume/Details/' . $_SESSION['currentEmail'] . '.json', json_encode($applicantData));

    
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
             <br><br>
             finished!
        </div>

        <!-- bootstrap json -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>