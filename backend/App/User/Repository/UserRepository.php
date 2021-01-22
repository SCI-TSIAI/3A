<?php namespace App\User\Repository;


use App\Database\DatabaseConnector;
use App\Database\Repository\Repository;
use App\User\Entity\UserEntity;
use PDO;

class UserRepository extends Repository {

    protected function getEntityName() {
        return "App\User\Entity\UserEntity";
    }

    protected function getTableName() {
        return "user";
    }
}