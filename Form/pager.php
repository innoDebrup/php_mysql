<?php
session_start();
if (!isset($_SESSION['flag'])) {
  header('Location: ../Relogin.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Basic Assignment 6</title>
  <!--  Linked external CSS file. -->
  <link rel="stylesheet" href="../CSS/form.css" type="text/css">
</head>

<body>
  <div class="header-link">
    <a href="../logout.php">Logout</a>
  </div>
  <!-- Main Form. -->
  <div class="form">
    <form action="./result.php" method="post" enctype="multipart/form-data">
      <fieldset>
        <legend>Personal Details</legend>
        <!-- First-name input field. -->
        <label for="firstName">First Name: </label>
        <input type="text" name="firstName" pattern="[A-Za-z]+" placeholder="Enter your first name" oninput=update() maxlength="20" id="firstName" required>
        <!-- Last-name input field. -->
        <label for="lastName">Last Name: </label>
        <input type="text" name="lastName" pattern="[A-Za-z]+" placeholder="Enter your last name" oninput=update() maxlength="20" id="lastName" required>
        <!-- Full-name input field (Disabled/Non-editable). -->
        <label for="fullName">Full Name: </label>
        <input type="text" name="fullName" id="fullName" disabled>
        <!-- Input the file to be uploaded. -->
        <label for="image">Choose an image file: </label>
        <input type="file" name="image" accept="image/*" required>
        <label for="marks">Marks: </label>
        <textarea name="marks" placeholder="Type each subject's marks in separate lines in the given format ==> Subject|Marks (Invalid inputs will be discarded)" id="marksArea" cols="30" rows="10"></textarea>
        <label for="number">Phone Number: </label>
        <input type="text" name="number" pattern="\+91[ ]*[0-9]{10}" placeholder="Format: +91 XXXXXXXXXX" id="phoneNumber" required>
        <label for="email">Email: </label>
        <input type="text" name="email" id="email">
        <!-- Submit button. -->
        <input type="submit" value="submit" name="submit">
      </fieldset>
    </form>
  </div>
  <!-- Include the script.  -->
  <script src="../JS/script.js"></script>
</body>

</html>