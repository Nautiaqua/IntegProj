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
            <h2>Resume Portal</h2>
            Search Applicant:
            <input type="text" id="searchInput">

            <br><br>

            <table border="1" cellpadding="5" id="applicantTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $files = glob("resumes/*.json");

                    foreach($files as $file){

                        $json = file_get_contents($file);
                        $data = json_decode($json,true);

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

        <!-- bootstrap json -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
    <script>

document.getElementById("searchInput")
.addEventListener("keyup", function(){

    var value = this.value.toLowerCase();

    var rows =
    document.querySelectorAll("#applicantTable tbody tr");

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