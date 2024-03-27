<?php
require 'ConnectDB.php';

/**
 * Class to run SQL Queries.
 */
class Query extends ConnectDB {
  
  /**
   * Function to add new users to the table.
   *
   * @param string $user_name
   *  User name for the new account.
   * @param string $email
   *  Email for the new account.
   * @param string $password
   *  Password set for the new account.
   * 
   * @return void
   */
  public function addUser(string $user_name, string $email, string $password) {
    $conn = $this->getConn();
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO Users (user_name, email, password) VALUES (:username, :email, :password);');
    $stmt->execute([
      'username' => $user_name, 
      'email' => $email,
      'password' => $password_hash,
    ]);
  }

  /**
   * Function to add Token for Resetting password.
   *
   * @param string $email
   *  Email of the account whose Password is to be reset and Token generated.
   * 
   * @return void
   */
  public function addToken(string $email) {
    $conn = $this->getConn();
    $token = bin2hex(random_bytes(16));
    $token_hash = hash('sha256',$token);
    $expiry = date('Y-m-d H:i:s', time() + 60 * 2);
    $stmt = $conn->prepare("UPDATE Users SET reset_token = :token, token_timer = :timer WHERE email = :email;");
    $stmt->execute([
      'token' => $token_hash,
      'timer' => $expiry,
      'email' => $email
    ]);
  }

  /**
   * Function to reset password.
   *
   * @param integer $user_id
   *  User-id of the account whose password is to be reset.
   * @param string $password
   *  New Password for the account.
   * 
   * @return void
   */
  public function resetPass(int $user_id, string $password) {
    $conn = $this->getConn();
    $stmt = $conn->prepare("UPDATE Users SET password = :password, reset_token = NULL, token_timer = NULL WHERE user_id = :user_id;");
    $stmt->execute([
      'password' => $password,
      'user_id' => $user_id
    ]);
  }

  /**
   * Function to get the Token of an account.
   *
   * @param string $email
   *  Email of the account from which the token is to be read.
   * 
   * @return mixed
   *  An array containing the reset_token and the token_timer.
   */
  public function getToken(string $email) {
    $conn = $this->getConn();
    $stmt = $conn->prepare("SELECT reset_token, token_timer FROM Users WHERE email=:email;");
    $stmt->execute([
      'email' => $email
    ]);
    $result_array = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result_array;
  }

  /**
   * Function to check if the Token is present in the table.
   *
   * @param string $token
   *  Entered token which needs verification.
   * 
   * @return mixed
   *  An array containing the user_id and the token-timer.
   */
  public function checkToken(string $token) {
    $conn = $this->getConn();
    $stmt = $conn->prepare("SELECT user_id, token_timer FROM Users WHERE reset_token = :token;");
    $stmt->execute([
      'token' => $token
    ]);
    $result_array = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result_array;
  }

  /**
   * Function to check if the user exists or not.
   *
   * @param string $user_name
   *  Username to be searched for.
   * @param string $email
   *  Email to be searched for.
   * 
   * @return bool
   *  Returns FALSE if User/Email is present or TRUE if none are present.  
   */
  public function checkUser(string $user_name, string $email) {
    $conn = $this->getConn();
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_name = :username OR email = :email;");
    $stmt->execute([
      'username' => $user_name,
      'email' => $email
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result)) {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

  /**
   * Function to check if Email is present in the table or not.
   *
   * @param string $email
   *  Email which is to be searched for.
   * 
   * @return bool
   *  Returns TRUE if Email is present or FALSE if Email is not present.
   */
  public function checkEmail(string $email){
    $conn = $this->getConn();
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = :email ;");
    $stmt->execute([
      'email' => $email
    ]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Function to get the password of a given account.
   *
   * @param string $user_mail
   *  Email of the account whose password needs to be fetched.
   * 
   * @return string
   *  Returns the password(hash) in string format.
   */
  public function getPass(string $user_mail) {
    $conn = $this->getConn();
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_name = :user_mail OR email = :user_mail;");
    $stmt->execute([
      'user_mail' => $user_mail
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $password = $result['password'];
    return $password;
  }
}
