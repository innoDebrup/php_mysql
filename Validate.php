<?php
use GuzzleHttp\Client;
use Dotenv\Dotenv;
require 'vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Validate {
  private $emailError = '';
  private $passwordError = '';

  public function validEmail($email) {
    // Regular Expression to check if the email is in a valid format or not. 
    $regularExp = '/^[\w._]+@[\w]+(\.[a-z]{2,}){0,2}$/i';
    if (!preg_match($regularExp, $email)) {
      $this->emailError = 'Invalid Email address format!';
      return FALSE;
    }
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
  public function getEmailErr(){
    return $this->emailError;
  }
  public function getPasswordErr(){
    return $this->passwordError;
  }
}
