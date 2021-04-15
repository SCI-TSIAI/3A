<?php


namespace App\Permission\Repository;


use App\Database\Repository\Repository;

class PermissionRepository extends Repository {


  public function getByName($name) {

    $query = $this->prepare("Select * from " . $this->getTableName() . " where name=:name");

    $query->execute(array(
      ":name" => $name,
    ));

    return $query->fetch();

  }

  protected function getEntityName() {
    return "App\Permission\Entity\PermissionEntity";
  }

  protected function getTableName() {
    return "permission";
  }
}
