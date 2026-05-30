<?php
session_start();

if(!isset($_SESSION['employee']))
{
    header("Location: employee.php");
    exit();
}

if(isset($_POST['btnUploadPhoto']))
{
    $tmpFile = $_FILES['newPhoto']['tmp_name'];
    $newPhoto = $_FILES['newPhoto']['name'];
    $destination = "uploads/" . $newPhoto;

    if(move_uploaded_file($tmpFile, $destination))
    {
        $jsonFile = urldecode($_POST['json_file']);
        $data = json_decode(file_get_contents($jsonFile), true);
        $data['photo'] = $destination;
        file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
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
    </head>
    <body data-bs-theme="light">
        <div class="container-fluid">
            <div class="container mt-4">
                <div class="text-center mb-4">
                    <h1>Welcome, <?php echo $_SESSION['employee']; ?></h1>
                    <h4>Resume Applicants</h4>
                    <input type="text" id="searchInput" placeholder="Search applicant...">
                    <br><br>

                    <label for="sortSelect">Sort by: </label>
                    <select id="sortSelect">
                        <option value="newest">Newest to Oldest</option>
                        <option value="oldest">Oldest to Newest</option>
                        <option value="age_asc">Age (Youngest First)</option>
                        <option value="age_desc">Age (Oldest First)</option>
                        <option value="name_asc">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                    </select>
                    <br><br>
                </div>

                <?php

                $files = glob("resumes/*.json");

                $applicants = array();

                foreach($files as $file)
                {
                    $data = json_decode(file_get_contents($file), true);
                    $data['_file'] = $file;
                    $data['_filemtime'] = filemtime($file);
                    $applicants[] = $data;
                }

                ?>

                <table border="1" cellpadding="5" width="100%" id="applicantTable">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Applying for</th>
                            <th>Submitted</th>
                            <th>Resume</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach($applicants as $data)
                    {
                        $photo = "";

                        if(!empty($data['photo']) && file_exists($data['photo']))
                        {
                            $photo = $data['photo'];
                        }
                        elseif(!empty($data['image']) && file_exists($data['image']))
                        {
                            $photo = $data['image'];
                        }

                        $resumeFile = "";

                        if(!empty($data['resume_file']) && file_exists($data['resume_file']))
                        {
                            $resumeFile = $data['resume_file'];
                        }
                        elseif(!empty($data['resume']) && file_exists($data['resume']))
                        {
                            $resumeFile = $data['resume'];
                        }

                        if(!empty($data['age']))
                        {
                            $age = $data['age'];
                        }
                        else
                        {
                            $age = "";
                        }

                        $submitted = date("Y-m-d", $data['_filemtime']);

                        $fileEncoded = urlencode($data['_file']);

                        echo "<tr
                            data-name='" . htmlspecialchars($data['name']) . "'
                            data-age='" . htmlspecialchars($age) . "'
                            data-time='" . $data['_filemtime'] . "'
                        >";

                        echo "<td>";

                        if(!empty($photo))
                        {
                            $imagePath = $photo;
                            echo "<img src='" . htmlspecialchars($imagePath) . "' alt='Photo' width='50' height='50' style='object-fit:cover; border-radius:4px;'>";
                        }
                        else
                        {
                            echo "<span>No photo</span>";
                        }

                        echo "<br>";
                        echo "<form method='POST' enctype='multipart/form-data'>";
                        echo "<input type='hidden' name='json_file' value='" . $fileEncoded . "'>";
                        echo "<input type='hidden' name='MAX_FILE_SIZE' value='2097152'>";
                        echo "<input type='file' name='newPhoto' accept='image/*'>";
                        echo "<button type='submit' name='btnUploadPhoto'>Upload</button>";
                        echo "</form>";

                        echo "</td>";

                        echo "<td>" . htmlspecialchars($data['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($data['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($age) . "</td>";
                        echo "<td>" . htmlspecialchars($data['applyingfor']) . "</td>";
                        echo "<td>" . $submitted . "</td>";

                        echo "<td>";
                        if(!empty($resumeFile))
                        {
                            echo "<a href='download_resume.php?file=" . urlencode($resumeFile) . "' class='btn btn-sm btn-primary'>Download</a>";
                        }
                        else
                        {
                            echo "<span>No file</span>";
                        }
                        echo "</td>";

                        echo "</tr>";
                    }

                    ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- bootstrap json -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
    <script>

document.getElementById("searchInput").addEventListener("keyup", function(){

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll("table tbody tr");

    rows.forEach(function(row){

        if(row.textContent.toLowerCase().includes(value)){
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });

});

document.getElementById("sortSelect").addEventListener("change", function(){

    let sortBy = this.value;

    let tbody = document.querySelector("#applicantTable tbody");
    let rows = Array.from(tbody.querySelectorAll("tr"));

    rows.sort(function(a, b){

        if(sortBy === "newest"){
            return b.dataset.time - a.dataset.time;
        }

        if(sortBy === "oldest"){
            return a.dataset.time - b.dataset.time;
        }

        if(sortBy === "age_asc"){
            return (parseInt(a.dataset.age) || 0) - (parseInt(b.dataset.age) || 0);
        }

        if(sortBy === "age_desc"){
            return (parseInt(b.dataset.age) || 0) - (parseInt(a.dataset.age) || 0);
        }

        if(sortBy === "name_asc"){
            return a.dataset.name.localeCompare(b.dataset.name);
        }

        if(sortBy === "name_desc"){
            return b.dataset.name.localeCompare(a.dataset.name);
        }

    });

    rows.forEach(function(row){
        tbody.appendChild(row);
    });

});

    </script>
</html>