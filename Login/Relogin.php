<?php
session_start();
if(isset($_SESSION['flag'])){
  header('Location: ../Form/pager.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/style.css">
  <title>Please Login</title>
</head>
<body>
  <div class="container">
    <div class="vert-form">
      <h1>Please Login !!!</h1>
      <a href="index.php">Go to Login</a>
    </div>
  </div>
</body>
</html>