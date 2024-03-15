<?php
$fullName = $marksInput = "";
$marksArray = $marksFinal = $marksErrorMessage = [];
$marksError = 0;
$re1 = '/^[a-z]+$/i'; // Regex to check all characters of the string are only alphabets.
$re2 = '/^[a-z]+[ ]*\|[ ]*[0-9]{1,3}$/i';    // Regex for validating Input Format of Marks.
$firstName = htmlspecialchars($_POST['firstName']);
$lastName = htmlspecialchars($_POST['lastName']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (preg_match($re1, $firstName) && preg_match($re1, $lastName)) {
        $fullName = $firstName . " " . $lastName;
    }
    $marksInput = $_POST["marks"];
    $marksArray = explode("\n", $marksInput);   // Exploding the string to form a string array. Point of exploding is a newline character.
    $n = count($marksArray);
    for ($i = 0; $i < $n; $i++) {
        $marksArray[$i] = trim($marksArray[$i]);    // Trimming any whitespaces at the beginning and end of the string.
        $marksArray[$i] = preg_replace('/[ ]/', '', $marksArray[$i]);   // Cleaning up spaces in the string.
        //---------- Set error if a string does not match the given format. ---------
        if (!preg_match($re2, $marksArray[$i])) {
            $marksError = 1;
            array_push($marksErrorMessage, "Incorrect Marks Format at line " . $i + 1);
            unset($marksArray[$i]);
        }
        //--------------------------------------------------------------------------
    }
    $marksArray = array_values($marksArray);
    foreach ($marksArray as $x) {
        array_push($marksFinal, explode("|", $x));
        // The marksFinal is an array of string arrays, 
        // where each string array consists a subject name at 0th index and the marks at the 1st index.
    }
}