<?php
// Logs out of current session by unsetting all $_SESSION variables and then destroying the session completely.
session_start();
if (!isset($_SESSION['flag'])) {
  header('Location: index.php');
  exit;
}
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout</title>
  <link rel="stylesheet" href="./CSS/style.css" type="text/css">
</head>

<body>
  <div class="container">
    <!-- Displays the user that they have successfully logged out of the session. -->
    <div class="vert-form">
      <div>
        <h1>Logged-Out Successfully</h1>
      </div>
      <!-- Links back to the Login page for users to Login again. -->
      <div>
        <a href="index.php">Login Again</a>
      </div>
    </div>

  </div>
</body>

</html>