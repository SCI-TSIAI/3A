<?php


namespace App\User\Model;


class AddUserRequest {

    private $username;
    private $password;

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return AddUserRequest
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return AddUserRequest
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }
}