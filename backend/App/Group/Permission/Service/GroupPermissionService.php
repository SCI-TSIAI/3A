<?php


namespace App\Group\Permission\Service;


use App\Group\Permission\Repository\GroupPermissionRepository;

class GroupPermissionService {

  private $groupPermissionRepository;

  /**
   * GroupPermissionService constructor.
   */
  public function __construct() {
    $this->groupPermissionRepository = new GroupPermissionRepository();
  }

  public function isGroupPermissionExists($groupId, $permissionId) {
    return $this->groupPermissionRepository->isGroupPermissionExists($groupId, $permissionId);
  }
}
