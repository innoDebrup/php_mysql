<?php
session_start();
if (!isset($_SESSION['flag'])) {
  header('url: ../Login/Relogin.php');
}
require "upload.php";
require "phoneNumber.php";
require "email.php";
require "nameMarks.php";
if (!($uploadOk === 0 || $marksError === 1 || $phoneError === 1 || $emailError === 1)) {
  require "pdf.php";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Basic Assignment Output</title>
  <link rel="stylesheet" href="../CSS/form.css" type="text/css">
</head>

<body>
  <!-- If any error occurs then show this div. -->
  <div class="<?php echo ($uploadOk === 0 || $marksError === 1 || $phoneError === 1 || $emailError === 1) ? "error" : "hide"; ?>">
    <div class="header-link">
      <a href="../Login/logout.php">Logout</a>
    </div>
    <span>ERROR!</span>
    <p>
      <?php
      if ($uploadOk === 0) {
        echo $errorMessage;
      } elseif ($marksError === 1) {
        foreach ($marksErrorMessage as $x) {
          echo $x . nl2br("\n");
        }
      } else if ($phoneError) {
        echo $phoneErrorMessage;
      } else {
        echo $emailErrorMessage;
        echo $validError;
      }
      ?>
    </p>
  </div>
</body>

</html>
