<?php namespace App\Router;

use Bramus\Router\Router;

class RestRouter {

    private static $router;

    public static function run() {
        if (empty(self::$router)) {
            self::$router = new Router();
            self::$router->setNamespace("\App\Controller");
            //TODO consider to register routes here?

            self::$router->get('/user', 'UserController@getUsers');
            self::$router->get('/user/{id}', 'UserController@getUser');

            self::$router->post('/user', 'UserController@addUser');

            self::$router->put('/user/{id}', 'UserController@updateUser');
            self::$router->delete('/user/{id}', 'UserController@deleteUser');

            self::$router->before('GET|POST|PUT|DELETE', '/.*', function () {
                header("Content-type: application/json");
            });

            self::$router->run();
        }
    }

    public static function getInstance() {
        if (empty(self::$router)) {
            self::run();
        }

        return self::$router;
    }
}