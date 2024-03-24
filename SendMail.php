<?php
require_once 'vendor/autoload.php';
require_once 'LoadEnv.php';
use PHPMailer\PHPMailer\PHPMailer;

class SendMail {
  private $content;
  /**
   * Function to send mail.
   *
   * @param string $email
   * Email id to which the email is to be sent to.
   * 
   * @return void
   */
  public function sendMail($email) {
    $mail = new PHPMailer(TRUE);
    $mail->isSMTP();
    // Setting the sender mail configuration.
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = TRUE;
    // Accessing key values from .env file.
    LoadEnv::loadDotEnv();
    $mail->Username = $_ENV['USER_NAME'];
    $mail->Password = $_ENV['PASSWORD'];
    // SMTP port.
    $mail->Port = 465;
    // Standard TLS encryption.
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    // Setting Receipient Mail and the message to send.
    $mail->isHTML(TRUE);
    $mail->setFrom($mail->Username);
    $mail->addAddress($email);
    $mail->Subject = ("Reset Your Password !!");
    $mail->Body = "Click this <a href='$this->content'>link</a> to reset the password.";
    $mail->send();
  }
  public function setContent(string $message) {
    $this->content = $message;
  }
}
