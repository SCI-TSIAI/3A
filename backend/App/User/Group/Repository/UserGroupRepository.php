<?php


namespace App\User\Group\Repository;


use App\Database\Repository\Repository;

class UserGroupRepository extends Repository {

  protected function getEntityName() {
    return "App\User\Group\Entity\UserGroupEntity";
  }

  protected function getTableName() {
    return "group";
  }
}
