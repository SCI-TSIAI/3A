<?php


namespace App\User\Group\Service;


use App\User\Entity\UserEntity;
use App\User\Group\Repository\UserGroupRepository;

class UserGroupService {

  private $userGroupRepository;

  /**
   * UserGroupService constructor.
   */
  public function __construct() {
    $this->userGroupRepository = new UserGroupRepository();
  }

  public function getUserGroup(UserEntity $entity) {
    return $this->userGroupRepository->getById($entity->getGroupId());
  }
}
