<?php
require_once '../Database/Query.php';
require_once '../SendMail.php';

$query = new Query();
$send_mail = new SendMail();
$sent = 0;
if($_SERVER['REQUEST_METHOD']=='POST'){
  $email = htmlspecialchars($_POST['email']);
  $email_present = $query->checkEmail($email);
  // Send Reset Link to the email only if it is registered.
  if ($email_present) {
    $query->addToken($email);
    $token_arr = $query->getToken($email);
    $reset_link = 'http://mysql/Login/resetpass.php?token='.$token_arr['reset_token'];
    $send_mail->setContent($reset_link);
    $send_mail->sendResetMail($email);
    $sent = 1;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/style.css">
  <title>Forgot Password</title>
</head>
<body>
  <div class="container">
    <div>
      <div class="main-head">
        <h1>
          Forgot Password
        </h1>
      </div>
      <div class="vert-form">
        <form action="forgotpass.php" method="post">
          <label for="email">Email</label>
          <input type="email" name="email" required>
          <div class="options">
            <ul>
              <li><a href="index.php">Go Back to Login</a></li>
            </ul>
          </div>
          <input type="submit" value="Submit">
        </form>
        <?php if($sent): ?>
        <div>
          <h2>Reset Link sent!!! Check your mail !</h2>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>