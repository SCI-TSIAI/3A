<?php


namespace App\Group\Permission\Entity;


use App\Database\Entity\Entity;

class GroupPermissionEntity extends Entity {

  private $group_id;
  private $permission_id;
  private $created_at;

  public function getId() {
    return null;
  }


}
