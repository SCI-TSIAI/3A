<?php


namespace App\User\Controller;
use App\Router\RestBodyReader;
use App\Serializer\JsonSerializer;
use App\User\Model\UserRequest;
use App\User\Service\AuthService;

/**
 * @Controller(path="/auth")
 */
class AuthController {

    private $authService;

    /**
     * AuthController constructor.
     */
    public function __construct() {
        $this->authService = new AuthService();
    }

    /**
     * @Action(method="POST", path="/login")
     */
    public function loginAction() {
        /** @var UserRequest $requestBody */
        $requestBody = RestBodyReader::readBody(UserRequest::class);

        $tokenObject = $this->authService->login($requestBody->getUsername(), $requestBody->getPassword());

        echo JsonSerializer::getInstance()->serialize($tokenObject, 'json');
    }
}