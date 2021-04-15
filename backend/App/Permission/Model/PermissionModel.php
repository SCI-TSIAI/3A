<?php


namespace App\Permission\Model;


class PermissionModel {

  private $id;
  private $name;

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getName() {
    return $this->name;
  }
}
