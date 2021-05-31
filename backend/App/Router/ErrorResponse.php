<?php


namespace App\Router;


class ErrorResponse {

  private $message;
  private $timestamp;

  /**
   * ErrorResponse constructor.
   * @param $message
   */
  public function __construct($message) {
    $this->message = $message;
    $this->timestamp = time();
  }

  /**
   * @return mixed
   */
  public function getMessage() {
    return $this->message;
  }
}
