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

    public function isUserWithPasswordExists($username, $password) {
        $query = $this->prepare("Select * from " . $this->getTableName() . " where username=:username and password_hash=:password_hash");

        $query->execute(array(
            ":username" => $username,
            ":password_hash" => sha1($password)
        ));

        return $query->rowCount() > 0;
    }
}