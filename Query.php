<?php
require 'ConnectDB.php';

class Query {

  public function addUser(string $user_name, string $email, string $password) {
    $database = new ConnectDB();
    $conn = $database->getConn();
    $user_name = $conn->real_escape_string($user_name);
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO Users (user_name, email, password) VALUES (?, ?, ?);');
    $stmt->bind_param('sss', $user_name, $email, $password);
    $stmt->execute();
    $stmt->close();
    $database->closeConnection();
  }

  public function addToken(string $email) {
    $database = new ConnectDB();
    $conn = $database->getConn();
    $email = $conn->real_escape_string($email);
    $token = bin2hex(random_bytes(16));
    $token_hash = hash('sha256',$token);
    $expiry = date('Y-m-d H:i:s', time() + 60 * 2);
    $stmt = $conn->prepare("UPDATE Users SET reset_token = ?, token_timer = ? WHERE email = ?;");
    $stmt->bind_param('sss', $token_hash, $expiry, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $database->closeConnection();
  }

  public function resetPass(int $user_id, string $password) {
    $database = new ConnectDB();
    $conn = $database->getConn();
    $stmt = $conn->prepare("UPDATE Users SET password = ?, reset_token = NULL,token_timer = NULL WHERE user_id = ?;");
    $stmt->bind_param('ss', $password, $user_id);
    $stmt->execute();
    $stmt->close();
    $database->closeConnection();
  }
  public function getToken(string $email) {
    $database = new ConnectDB();
    $conn = $database->getConn();
    $email = $conn->real_escape_string($email);
    $stmt = $conn->prepare("SELECT reset_token, token_timer FROM Users WHERE email=?;");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $database->closeConnection();
    $result_array = $result->fetch_assoc();
    return $result_array;
  }

  public function checkToken(string $token) {
    $database = new ConnectDB();
    $conn = $database->getConn();
    $stmt = $conn->prepare("SELECT user_id, token_timer FROM Users WHERE reset_token = ?;");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $database->closeConnection();
    $result_array = $result->fetch_assoc();
    return $result_array;
  }

  public function checkUser(string $user_name, string $email) {
    $database = new ConnectDB();
    $conn = $database->getConn();
    $user_name = $conn->real_escape_string($user_name);
    $email = $conn->real_escape_string($email);
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_name=? OR email=?;");
    $stmt->bind_param('ss', $user_name, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $database->closeConnection();

    if ($result->num_rows) {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

  public function checkEmail(string $email){
    $database = new ConnectDB();
    $conn = $database->getConn();
    $email = $conn->real_escape_string($email);
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email=?;");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $database->closeConnection();

    if ($result->num_rows) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  public function getPass(string $user_mail) {
    $database = new ConnectDB();
    $conn = $database->getConn();
    $user_mail = $conn->real_escape_string($user_mail);
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_name=? OR email=?;");
    $stmt->bind_param('ss', $user_mail, $user_mail);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $database->closeConnection();

    $password = $result->fetch_assoc()['password'];
    return $password;
  }
}