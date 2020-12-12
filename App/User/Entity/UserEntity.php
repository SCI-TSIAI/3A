<?php namespace App\User\Entity;

use App\Database\Entity\Entity;

class UserEntity extends Entity {

    private $id;
    private $group_id;
    private $username;
    private $password_hash;
    private $last_login;
    private $created_at;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGroupId() {
        return $this->group_id;
    }

    /**
     * @param mixed $group_id
     */
    public function setGroupId($group_id) {
        $this->group_id = $group_id;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash() {
        return $this->password_hash;
    }

    /**
     * @param mixed $password_hash
     */
    public function setPasswordHash($password_hash) {
        $this->password_hash = $password_hash;
    }

    /**
     * @return mixed
     */
    public function getLastLogin() {
        return $this->last_login;
    }

    /**
     * @param mixed $last_login
     */
    public function setLastLogin($last_login) {
        $this->last_login = $last_login;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
}