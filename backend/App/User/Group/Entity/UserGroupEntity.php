<?php


namespace App\User\Group\Entity;


use App\Database\Entity\Entity;

class UserGroupEntity extends Entity {

  private $id;
  private $name;
  private $created_at;

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

  /**
   * @param mixed $name
   * @return UserGroupEntity
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getCreatedAt() {
    return $this->created_at;
  }

  /**
   * @param mixed $created_at
   * @return UserGroupEntity
   */
  public function setCreatedAt($created_at) {
    $this->created_at = $created_at;
    return $this;
  }
}
