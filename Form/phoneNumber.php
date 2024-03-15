<?php
$phone = $phoneErrorMessage = "";
$phoneError = 0;
$re = '/^\+91[ ]*[0-9]{10}$/';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $phone = $_POST["number"];
        if ( !preg_match($re, $phone)) {
            $phoneError = 1;
            $phoneErrorMessage = 'Incorrect phone no. format!';
        }
    }
    