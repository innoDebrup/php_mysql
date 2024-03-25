<?php
require_once '../Database/Query.php';
require_once './OTP.php';
session_start();
$success = FALSE;
$err = '';
if (isset($_SESSION['otp'])) {
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $password = $_SESSION['password'];
  $otp = $_SESSION['otp'];

  var_dump($username, $email, $password, $otp);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['entered_otp'] == $otp) {
      $query = new Query();
      $query->addUser($username, $email, $password);
      echo "Entered the new user";
      $success = TRUE;
    }
    else {
      $err = 'Invalid OTP given';
    }
  }
}
else {
  header('Location: index.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/style.css">
  <title>OTP</title>
</head>

<body>
  <div class="container">
    <div>
      <div class="main-head">
        <h1>
          Enter your OTP
        </h1>
        <h2>OTP has been sent to your email.</h2>
      </div>
      <div class="vert-form">
        <form action="otpcheck.php" method="post">
          <label for="entered_otp">OTP</label>
          <input type="text" name="entered_otp">
          <input type="submit" value="Submit" <?php if ($success) echo 'disabled';?> >
        </form>
      </div>
    </div>
    <div class="main-head">
      <?php if (!empty($err)): ?>
        <h2><?php echo $err;?></h2>
      <?php endif; ?>
      <?php if ($success): ?>
        <?php 
        session_unset();
        session_destroy();
        ?>
        <h2><?php echo "New User Created Successfully!!! Please Login!" ?></h2>
        <a href = "./index.php">Go to Login Page</a>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>