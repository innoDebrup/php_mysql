<?php
require_once 'vendor/autoload.php';
require_once 'LoadEnv.php';
use GuzzleHttp\Client;

class Validate {
  private $emailError = '';
  private $passwordError = '';

  public function validEmail($email) {
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
      $this->emailError = 'Invalid Email address format!';
      return FALSE;
    }
    LoadEnv::loadDotEnv();
    // $client = new Client();
    // $access_key = $_ENV['ACCESS_KEY'];
    // $response = $client->request('GET', 'https://emailvalidation.abstractapi.com/v1/?api_key=' . $access_key . '&email=' . $email);
    // // Stores the response received in the form of an array.
    // $data = json_decode($response->getBody(), TRUE);
    // if ($data["is_disposable_email"]["value"]) {
    //   $this->emailError = 'Cannot use temporary Email address!';
    //   return FALSE;
    // } 
    // elseif ($data['deliverability'] === 'UNDELIVERABLE') {
    //   $this->emailError = 'Email address does not exists!';
    //   return FALSE;
    // } 
    // else {
      return TRUE;
    // }
  }
  public function validPassword($password) {
    if (strlen($password) < 6 ) {
      $this->passwordError = 'Password cannot be less than 6 characters!';
      return FALSE;
    }
    else if (strlen($password) > 20) {
      $this->passwordError = 'Password cannot be more than 20 characters!';
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

  public function genOTP() {
    $otp = rand(1000, 9999);
    return $otp;
  }

  public function getEmailErr() {
    return $this->emailError;
  }
  public function getPasswordErr() {
    return $this->passwordError;
  }
}
