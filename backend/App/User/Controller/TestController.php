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
 * @Controller(path="/test")
 */
class TestController {

    /**
     * @Authorized(permission="test_action_permission")
     * @Action(method="GET")
     */
    public function testAction() {
        echo json_encode(array("test" => "test"));
    }
}