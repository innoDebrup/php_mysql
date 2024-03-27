<?php
require_once '../SendMail.php';
require_once '../Validate.php';

/**
 * Class for generating and sending OTP.
 */
class OTP {
  /**
   * Function to generate and send OTP to mail.
   *
   * @param string $email
   *  Email to send the OTP to.
   * 
   * @return int
   *  Return the OTP generated.
   */
  public static function processOTP(string $email) {
    $mail = new SendMail();
    $valid_ob = new Validate();
    $otp = $valid_ob->genOTP();
    $mail->setContent($otp);
    $mail->sendOTPMail($email);
    return $otp;
  }
}
