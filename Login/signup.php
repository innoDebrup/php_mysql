<?php
require_once '../Database/Query.php';
require_once '../Validate.php';

$query = new Query();
$validator = new Validate();
$not_duplicate = TRUE;
$valid_email = TRUE;
$valid_password = TRUE;
$valid_input = TRUE;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  $user_name = htmlspecialchars($_POST['user_name']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  if (!empty($user_name) && !empty($email) && !empty($password)) {
    $not_duplicate = $query->checkUser($user_name, $email);
    $valid_email = $validator->validEmail($email);
    $valid_password = $validator->validPassword($password);

    if ($not_duplicate && $valid_email && $valid_password) {
      $query->addUser($user_name, $email, $password);
      header('Location: index.php?message=' . urlencode('ACCOUNT CREATED SUCCESSFULLY. PLEASE LOGIN !!'));
      exit;
    }
  }
  else {
    $valid_input = FALSE;
  }
  
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/style.css">
  <title>Sign Up</title>
</head>

<body>
  <div class="container">
    <div>
      <div class="main-head">
        <h1>
          Sign Up Now!
        </h1>
      </div>
      <div class="vert-form">
        <form action="signup.php" method="post">
          <label for="user_name">Username</label>
          <input type="text" name="user_name">
          <label for="email">Email</label>
          <input type="email" name="email">
          <label for="password">Password</label>
          <input type="password" name="password">
          <div class="options">
            <ul>
              <li><a href="index.php">Go Back to Login</a></li>
            </ul>
          </div>
          <input type="submit" value="Submit">
        </form>
      </div>
    </div>

    <?php if (!$not_duplicate) : ?>
      <div class="center">
        <h2>Account already exists with the same username or email !!!</h2>
      </div>
    <?php endif; ?>
    <?php if (!$valid_email) : ?>
      <div class="center">
        <h2><?php echo $validator->getEmailErr(); ?></h2>
      </div>
    <?php endif; ?>
    <?php if (!$valid_password) : ?>
      <div class="center">
        <h2><?php echo $validator->getPasswordErr(); ?></h2>
      </div>
    <?php endif; ?>
    <?php if (!$valid_input) : ?>
      <div class="center">
        <h2>Please fill all fields.</h2>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>
