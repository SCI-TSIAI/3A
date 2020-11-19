<?php namespace App\User\Repository;


use App\Database\DatabaseConnector;
use App\User\Entity\UserEntity;
use PDO;

class UserRepository {

    private $databaseConnection;

    /**
     * UserRepository constructor.
     */
    public function __construct() {
        $this->databaseConnection = DatabaseConnector::getInstance();
    }

    /**
     * @param $id
     * @return UserEntity
     */
    public function findById($id) {
        $stmt = $this->databaseConnection
            ->prepare("Select * from user where id=:id");

        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->getEntityName());
        $stmt->execute(array(":id" => $id));

        return $stmt->fetch();
    }

    private function getEntityName() {
        return "App\User\Entity\UserEntity";
    }
}