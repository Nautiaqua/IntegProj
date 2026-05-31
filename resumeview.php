<?php
    session_start();

    if(!isset($_SESSION['currentEmail']))
    {
        header("Location: employee.php");
        exit();
    }

    // part that handles search storage   
    if(isset($_POST['btnSearch']))
    {
        $searchInput = trim($_POST['searchInput']);
        if (empty(trim($searchInput))) $_SESSION['currentSearch'] = null;
        else $_SESSION['currentSearch'] = $searchInput;
    }

    function nameFilter($applicant) {
        if (str_contains($applicant, $_SESSION['currentSearch']))
            return $applicant;
    }
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
            <div class="container mt-4 p-5" style="background-color: white; border-radius: 1.6rem;">
                <div class="row">
                    <div class="col"><h1>Welcome, <?php echo $_SESSION['currentEmail']; ?></h1></div>
                </div>
                <div class="row">
                    <h4>Resume Applicants</h4>
                </div>

                <form method="post" action="resumeview.php">
                    <div class="row">
                        <div class="col-4">
                            <input type="text" name="searchInput" style="width: fill;" class="form-control bg-body-secondary border-0" placeholder="Search for Applicant Name" 
                                value="<?php
                                    if (isset($_SESSION['currentSearch']) && $_SESSION['currentSearch'] != "") echo $_SESSION['currentSearch'];
                                    else echo "";?>"
                                >
                        </div>
                        <div class="col-8 d-flex justify-content-start">
                            <input name="btnSearch" type="submit" class="btn btn-primary" style="width: 5rem; border-radius: 0.6rem; background-color: #0b81db;" value="Search"/>
                        </div>
                    </div>
                </form>

                <?php
                    $files = glob("resumes/*.json");

                    $applicants = array();

                    foreach($files as $file)
                    {
                        $data = json_decode(file_get_contents($file), true);
                        $data['_file'] = $file;
                        $data['_filemtime'] = filemtime($file);

                        // dis just turns the applicants array into an array of arrays
                        if (!empty($_SESSION['currentSearch'])) {
                            $applicants = array_filter($data, "nameFilter");
                        }
                        else $applicants[] = $data;
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
                        if (count($applicants) > 0) {
                            // dis actually handles the table generation
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
                        }
                        else echo "No valid applicants!";   
                        
                    ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- bootstrap json -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>