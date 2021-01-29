<?php


namespace App\Controller;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ReflectionClass;
use zpt\anno\Annotations;

/**
 * @Controller(path="/user")
 */
class UserController {

    /**
     * @Action(method="GET")
     */
    public function getUsers() {
        echo json_encode(array("test" => "test"));
    }

    /**
     * @Action(method="POST")
     */
    public function addUser() {
        $request = json_decode(file_get_contents('php://input'));

        echo json_encode(array("message" => "Added user successfully!"));
    }

    /**
     * @Action(method="GET", path="/{id}")
     */
    public function getUser($id) {
        echo sprintf("Obtained user with id: %s", array($id));
    }

    /**
     * @Action(method="PUT", path="/{id}")
     */
    public function updateUser($id) {
        echo sprintf("Updated user with id: %s", array($id));
    }

    /**
     * @Action(method="DELETE", path="/{id}")
     */
    public function deleteUser($id) {
        echo sprintf("Deleted user with id: %s", array($id));
    }
}