<?php
    // basic check for email format
    function emailCheck(string $email) {
        if (preg_match("/^[a-zA-Z0-9._-]{2,}+@[a-zA-Z0-9]{3,}+.[a-zA-Z]{2,}$/", $email))
            return true;
        else return false;
    }

    // password must have at least 1 small letter, capital letter, special character
    // and must be 8 characters long.
    function passwordCheck(string $password) {
        if (preg_match("/^(?=.*[A-Za-z])(?=.*\W)(?=.*\d)[A-Za-z\W\d]{8,}$/", $password))
            return true;
        else return false; 
    }  

    // we're using the license plate format of 3 letters and 3 numbers
    function plateCheck(string $platenumbers) {
        if (preg_match("/^[A-Z]{3}[0-9]{3}$/", $platenumbers))
            return true;
        else return false; 
    }

    // makes sure that the parking spot naming scheme is correct
    // it goes 1 capital letter and 1-2 numbers (ex: A1, B11, C23)
    function spotCheck(string $spotname) {
        if (preg_match("/^[A-Z][1-9][\d]?/", $spotname))
            return true;
        else return false; 
    }
?>