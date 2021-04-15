<?php


namespace App\Helpers\Model;


class TokenObject {

  private $user_id;
  private $sub;
  private $group_id;

  /**
   * TokenObject constructor.
   * @param $user_id
   * @param $sub
   */
  public function __construct($user_id, $sub) {
    $this->user_id = $user_id;
    $this->sub = $sub;
  }

  /**
   * @return mixed
   */
  public function getUserId() {
    return $this->user_id;
  }

  /**
   * @return mixed
   */
  public function getSub() {
    return $this->sub;
  }

  /**
   * @return mixed
   */
  public function getGroupId() {
    return $this->group_id;
  }
}
