<?php namespace App\Configuration;

class ConnectionConfiguration {

    //TODO Consider to move it to configuration file.
    private $dsn = "mysql:host=172.17.0.1:3306;dbname=gallery";
    private $username = "root";
    private $password = "root";

    /**
     * @return string
     */
    public function getDsn() {
        return $this->dsn;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }
}
