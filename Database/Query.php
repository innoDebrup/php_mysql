<?php
require 'ConnectDB.php';

class Query extends ConnectDB {

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

  public function resetPass(int $user_id, string $password) {
    $conn = $this->getConn();
    $stmt = $conn->prepare("UPDATE Users SET password = :password, reset_token = NULL, token_timer = NULL WHERE user_id = :user_id;");
    $stmt->execute([
      'password' => $password,
      'user_id' => $user_id
    ]);
  }
  public function getToken(string $email) {
    $conn = $this->getConn();
    $stmt = $conn->prepare("SELECT reset_token, token_timer FROM Users WHERE email=:email;");
    $stmt->execute([
      'email' => $email
    ]);
    $result_array = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result_array;
  }

  public function checkToken(string $token) {
    $conn = $this->getConn();
    $stmt = $conn->prepare("SELECT user_id, token_timer FROM Users WHERE reset_token = :token;");
    $stmt->execute([
      'token' => $token
    ]);
    $result_array = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result_array;
  }

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

  public function genOTP(string $email) {
    $conn = $this->getConn();
    $otp = rand(1000,9999);
    $sql = "";
  }

}