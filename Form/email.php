<?php
// require "access.php";
$email = $emailErrorMessage = $validError = "";
$emailError = 0;
$re = '/^[\w._]+@[\w]+(\.[a-z]{2,}){0,2}$/i';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $email = strtolower($email);

  if (!preg_match($re, $email)) {
    $emailError = 1;
    $emailErrorMessage = "Invalid email address format!";
  }

  // if ($emailError != 1) {
  //   $ch = curl_init();
  //   curl_setopt_array($ch, [
  //     CURLOPT_URL => 'https://emailvalidation.abstractapi.com/v1/?api_key=' . $access_key . '&email=' . $email,
  //     CURLOPT_RETURNTRANSFER => true,
  //     CURLOPT_FOLLOWLOCATION => false
  //   ]);
  //   $response = curl_exec($ch);
  //   $data = json_decode($response, true);

  //   if ($data["is_disposable_email"]["value"] === true) {
  //     $emailError = 1;
  //     $validError = "Disposable Emails are not allowed!";
  //   } elseif ($data['deliverability'] === 'UNDELIVERABLE') {
  //     $emailError = 1;
  //     $validError = "Invalid email as it is Undeliverable!";
  //   } else {
  //     $emailError = 0;
  //   }
  // }
}
