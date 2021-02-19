<?php

namespace App\User\Controller;

use App\Router\RestBodyReader;
use App\Serializer\JsonSerializer;
use App\User\Model\UserRequest;
use App\User\Service\UserService;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ReflectionClass;
use zpt\anno\Annotations;

/**
 * @Controller(path="/user")
 */
class UserController {

    private $userService;

    /**
     * UserController constructor.
     * @param $userService
     */
    public function __construct() {
        $this->userService = new UserService();
    }


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

        /** @var UserRequest $request */
        $request = RestBodyReader::readBody(UserRequest::class);

        $userEntity = $this->userService->createUser($request);

        echo JsonSerializer::getInstance()->serialize($userEntity, 'json');
    }

    /**
     * @Authorized
     * @Action(method="GET", path="/{id}")
     */
    public function getUser($id) {
        $userModel = $this->userService->getUser($id);

        echo JsonSerializer::getInstance()->serialize($userModel, 'json');
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