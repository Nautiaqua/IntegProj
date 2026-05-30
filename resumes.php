<?php
session_start();

if(!isset($_SESSION['employee']))
{
    header("Location: employee.php");
    exit();
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
                </div>

                <tbody>
                    <?php
                        $files = glob("resumes/*.json");
                        ?>

                        <table border="1" cellpadding="5" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Applying for</th>
                                </tr>
                            </thead>

                            <?php
                            foreach($files as $file){

                                $data = json_decode(file_get_contents($file), true);

                                echo "<tr>";
                                echo "<td>".$data['name']."</td>";
                                echo "<td>".$data['email']."</td>";
                                echo "<td>".$data['applyingfor']."</td>";
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
</script>
</html>
