<?php


namespace App\Permission\Service;


use App\Helpers\ObjectMapper;
use App\Permission\Model\PermissionModel;
use App\Permission\Repository\PermissionRepository;

class PermissionService {

  private $permissionRepository;

  /**
   * PermissionService constructor.
   */
  public function __construct() {
    $this->permissionRepository = new PermissionRepository();
  }

  /**
   * @param $name
   * @return PermissionModel
   */
  public function getByName($name) {
    $entity = $this->permissionRepository->getByName($name);
    return ObjectMapper::map($entity, PermissionModel::class);
  }
}
