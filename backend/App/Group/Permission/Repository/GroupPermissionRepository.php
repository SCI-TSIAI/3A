<?php


namespace App\Group\Permission\Repository;


use App\Database\Repository\Repository;
use App\User\Entity\UserEntity;

class GroupPermissionRepository extends Repository {


  public function isGroupPermissionExists($groupId, $permissionId) {
    $query = $this->prepare("Select * from " . $this->getTableName() . " where group_id=:group_id and permission_id=:permission_id");

    $query->execute(array(
      ":group_id" => $groupId,
      ":permission_id" => $permissionId
    ));

    return $query->rowCount() > 0;
  }

  protected function getEntityName() {
    return "App\Group\Permission\Entity\GroupPermissionEntity";
  }

  protected function getTableName() {
    return "group_permission";
  }
}
