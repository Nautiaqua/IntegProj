<!-- this is redundant, just too lazy to retool index.php -->
<?php
    session_start();

    if (!isset($_SESSION['currentEmail'])) {
        header("Location: index.php");
        exit();
    }
    
    if (isset($_COOKIE['loggedEmail']) && isset($_COOKIE['loggedPassword'])) {
        if (str_contains($_COOKIE['loggedEmail'], "@cloudtravels.ph")) {
            header("Location: resumeview.php");
            exit();
        }
    }
    $_SESSION["currentEmail"] = $_POST["genEmail"];

    $adminList = file('adminlist.txt', FILE_IGNORE_NEW_LINES);
    $isAdmin = false;
    foreach ($adminList as $email) {

        $emailIndex = array_search($email, $adminList);

        if ($emailIndex == 0 || $emailIndex % 4 == 0) {
            if ($email == $_POST['genEmail']) {
                $isAdmin = true;
            }
        }
    };

    if ($isAdmin == true) {
        header("Location: emplogin.php");
        exit();
    } else {
        header("Location: apply.php");
        exit();
    }
?>