<?php
require_once '../SendMail.php';
require_once '../Validate.php';
class OTP {
  public static function processOTP(string $email) {
    $mail = new SendMail();
    $valid_ob = new Validate();
    $otp = $valid_ob->genOTP();
    $mail->setContent($otp);
    $mail->sendOTPMail($email);
    return $otp;
  }
}
