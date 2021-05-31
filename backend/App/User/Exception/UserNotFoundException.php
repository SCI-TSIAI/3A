<?php


namespace App\User\Exception;


class UserNotFoundException extends NotFoundException {

  /**
   * UserNotFoundException constructor.
   */
  public function __construct() {
    parent::__construct("USER_NOT_FOUND");
  }
}
