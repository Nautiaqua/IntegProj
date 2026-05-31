<!-- just handles going between forms, i cooked wit this one -->
<?php
    session_start();
    
    $_SESSION["currentEmail"] = $_POST["genEmail"];
    if (str_contains($_SESSION["currentEmail"], "@cloudtravels.ph")) {
        header("Location: emplogin.php");
    }
    else header("Location: apply.php");
?>