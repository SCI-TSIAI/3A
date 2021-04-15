<?php


namespace App\Database\Repository;



use App\Database\DatabaseConnector;
use App\Database\Entity\Entity;
use App\Helpers\ReflectionUtils;
use PDO;

abstract class Repository {

    protected $databaseConnection;

    public function __construct() {
        $this->databaseConnection = DatabaseConnector::getInstance();
        $this->databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    /**
     * @param $id
     * @return Entity
     */
    public function getById($id) {
        $query = $this->prepare("Select * from `" . $this->getTableName() . "` where id=:id");

        $query->execute(array(
            ":id" => $id
        ));

        return $query->fetch();
    }

    /**
     * @param Entity $object
     * @return null
     * @throws \ReflectionException
     */
    public function save(Entity $object) {

        $result = null;

        if (empty($object->getId())) {
            $result = $this->performSave($object);
        } else {
            $result = $this->performUpdate($object);
        }

        return $result;
    }

    public function delete($id) {
        $query = $this->prepare("Delete from `" . $this->getTableName() . "` where id=:id");

        $query->execute(array(":id" => $id));

        return $query->rowCount();
    }

    public function deleteEntity(Entity $entity) {
        return $this->delete($entity->getId());
    }

    protected function prepare($statement) {
        $query = $this->databaseConnection->prepare($statement);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->getEntityName());

        return $query;
    }

    protected abstract function getEntityName();

    protected abstract function getTableName();

    /**
     * @param Entity $entity
     * @return null
     * @throws \ReflectionException
     */
    private function performSave(Entity $entity) {

        $fields = ReflectionUtils::getObjectPrivateFields($entity);

        $fields = self::removeNullValuesFromAssoc($fields);

        $fieldNamesString = implode(", ", array_keys($fields));

        $fieldPlaceholders = self::addPrefixToArrayKeys($fields, ":");
        $fieldPlaceholdersString = join(", ", array_keys($fieldPlaceholders));

        $sql = "INSERT INTO `" . $this->getTableName() . "`($fieldNamesString) VALUES ($fieldPlaceholdersString)";
        $stmt = $this->databaseConnection->prepare($sql);

        foreach ($fieldPlaceholders as $key => $value) {
            if (is_string($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            } else {
                $stmt->bindValue($key, $value);
            }
        }

        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            //TODO save it to logfile.
            return null;
        }

        return $this->getById($this->databaseConnection->lastInsertId());
    }

    private function performUpdate(Entity $entity) {
        $fields = ReflectionUtils::getObjectPrivateFields($entity);
        $pairsString = "";
        foreach ($fields as $key => $value) {
            $pairsString .= $key . "=:" . $key . ", ";
        }

        $pairsString = rtrim($pairsString, ", ");

        $sql = "UPDATE `" . $this->getTableName() . "` SET " . $pairsString . " where id=:id";
        $stmt = $this->databaseConnection->prepare($sql);

        $fieldPlaceholders = self::addPrefixToArrayKeys($fields, ":");

        foreach ($fieldPlaceholders as $key => $value) {
            if (is_string($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            } else {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->bindValue(":id", $entity->getId());

        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            //TODO save it to logfile.
            return null;
        }

        return $this->getById($entity->getId());
    }

    private static function addPrefixToArrayKeys($array, $prefix) {
        $resultArray = array();

        foreach ($array as $key => $value) {
            $resultArray[$prefix . $key] = $value;
        }

        return $resultArray;
    }

    private static function removeNullValuesFromAssoc($array) {

        return array_filter($array, function ($value) {
            return $value != null && $value != "";
        });
    }
}
