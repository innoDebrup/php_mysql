<?php
require_once 'vendor/autoload.php';
use Dotenv\Dotenv;

/**
 * Class for accessing phpdotenv operations.
 */
class LoadEnv {
  
  /**
   * Function to load .env file key value pairs into $_ENV.
   *
   * @return void
   */
  public static function loadDotEnv() {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
  }
}