<?php
  require_once 'Query.php';
  require_once 'Validate.php';
  if (!isset($_GET)) {
    header('Location: index.php');
    exit;
  }
  $message = '';
  $query = new Query();
  $validator = new Validate();
  $token = $_GET['token'];
  $self_link = 'resetpass.php?token='.$token;
  $returned_array = $query->checkToken($token);
  $reset = 0;
  if ($returned_array) {
    $user_id = $returned_array['user_id'];
    $token_timer = strtotime($returned_array['token_timer']);
    if ($token_timer <= time()) {
      $message = 'The link has expired. Please retry forgot password !!';
    }
    else {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = $_POST['password'];
        if ($validator->validPassword($password)) {
          $password_hash = password_hash($password, PASSWORD_DEFAULT);
          $query->resetPass($user_id, $password_hash);
          $message = 'Password Reset Successfully';
          $reset = 1;
        }
        else {
          $message = $validator->getPasswordErr();
        }
      }
    }
  }
  else{
    $message = 'Invalid Link!! Please retry forgot password process !!';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./CSS/style.css">
  <title>Forgot</title>
</head>
<body>
  <div class="container">
    <div>
      <div class="main-head">
        <h1>
          Reset Password
        </h1>
      </div>
      <?php if (!$reset): ?>
      <div class="vert-form">
        <form action="<?php echo $self_link; ?>" method="post">
          <label for="password">New Password</label>
          <input type="password" name="password">
          <input type="submit" value="Submit">
        </form>
        <div>
          <?php echo $message; ?>
        </div>
      </div>
      <?php endif;?>
      <?php if($reset): ?>
        <div class="vert-form">
          <h1><?php echo $message; ?></h1>
          <a href='index.php'>Go to Login page</a>
        </div>  
      <?php endif; ?>
    </div>
  </div>
</body>
</html>