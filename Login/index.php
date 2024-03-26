<?php
  require_once '../Database/Query.php';
  session_start();
  $query = new Query();
  $invalid = 0;
  // If session is present then Redirect to landing page.
  if (isset($_SESSION['flag'])) {
    header('Location: ../Form/pager.php');
    exit;
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_mail = htmlspecialchars($_POST['user_mail']);
    $password = htmlspecialchars($_POST['password']);
    $hash = $query->getPass($user_mail);
    // Check if account is present or not.
    if (!$hash){
      // Destroy session if it does not exist.
      $invalid = 1;
      session_destroy();
    }
    else{
      // Check if the password matches or not.
      if(password_verify($password, $hash)){
        $_SESSION['flag'] = 1;
        header('Location: ../Form/pager.php');
        exit;
      }
      else{
        $invalid = 1;
        session_destroy();
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/style.css" type="text/css">
  <title>Login Page</title>
</head>
<body>
  <div class="container">
    <?php if (isset($_GET['message'])): ?>
      <div class="center">
        <h2><?php echo $_GET['message']; ?></h2>
      </div>  
    <?php endif; ?>
    <div>
      <div class="main-head">
        <h1>
          Login
        </h1>
      </div>
      <div class="center">

      </div>
      <div class="vert-form">
        <form action="index.php" method="post">
          <label for="user_mail">Username/Email</label>
          <input type="text" name="user_mail" placeholder="Enter your username or email." required>
          <label for="password">Password</label>
          <input type="password" name="password" placeholder="Enter your password." required>
          <div class="options">
            <ul>
              <li>New Here? <a href="signup.php">Create an Account</a></li>
              <li>Forgot your Password? <a href="forgotpass.php">Click Here</a></li>
            </ul>
          </div>
          <input type="submit" value="Submit">
        </form>
        <?php if ($invalid): ?>
          <div>
            <h2>Invalid Username/Email or Password.</h2>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>