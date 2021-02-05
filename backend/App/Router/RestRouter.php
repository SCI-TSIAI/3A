<?php namespace App\Router;

use App\Helpers\ReflectionUtils;
use Bramus\Router\Router;
use HaydenPierce\ClassFinder\ClassFinder;
use ReflectionClass;
use zpt\anno\Annotations;

class RestRouter {

    const CONTROLLER_ANNOTATION_NAME = "Controller";
    const ACTION_ANNOTATION_NAME = "Action";
    const PATH_PARAMETER_NAME = "path";
    const METHOD_PARAMETER_NAME = "method";
    const MAIN_NAMESPACE = "App";

    private static $router;

    /**
     * @throws \ReflectionException
     * @throws \zpt\anno\ReflectorNotCommentedException
     */
    public static function run() {
        if (empty(self::$router)) {
            self::$router = new Router();

            self::$router->before('GET|POST|PUT|DELETE', '/.*', function () {
                header('Content-type: application/json');
            });

            self::autoloadRoutes();

            self::$router->run();
        }
    }

    /**
     * @param $classname
     * @throws \ReflectionException
     * @throws \zpt\anno\ReflectorNotCommentedException
     */
    private static function registerRoutes($classname) {

        $classReflector = new ReflectionClass($classname);
        $classAnnotations = new Annotations($classReflector);

        if (!$classAnnotations->hasAnnotation(self::CONTROLLER_ANNOTATION_NAME)) {
            return;
        }

        $controllerPath = $classAnnotations[self::CONTROLLER_ANNOTATION_NAME][self::PATH_PARAMETER_NAME];

        foreach ($classReflector->getMethods() as $methodReflector) {
            self::registerRoute($controllerPath, $methodReflector);
        }
    }

    /**
     * @param $controllerPath
     * @param \ReflectionMethod $methodReflector
     * @throws \Exception
     */
    private static function registerRoute($controllerPath, \ReflectionMethod $methodReflector) {

        $methodAnnotations = new Annotations($methodReflector);

        if (!$methodAnnotations->hasAnnotation(self::ACTION_ANNOTATION_NAME)) {
            return;
        }

        $actionMethod = strtoupper($methodAnnotations[self::ACTION_ANNOTATION_NAME][self::METHOD_PARAMETER_NAME]);

        $actionPath = $methodAnnotations[self::ACTION_ANNOTATION_NAME][self::PATH_PARAMETER_NAME];

        $path = !empty($actionPath) ? $controllerPath . $actionPath : $controllerPath;

        switch ($actionMethod) {
            case "GET":
                self::$router->get($path, ReflectionUtils::getFullMethodIdentifier($methodReflector));
                break;
            case "POST":
                self::$router->post($path, ReflectionUtils::getFullMethodIdentifier($methodReflector));
                break;
            case "PUT":
                self::$router->put($path, ReflectionUtils::getFullMethodIdentifier($methodReflector));
                break;
            case "DELETE":
                self::$router->delete($path, ReflectionUtils::getFullMethodIdentifier($methodReflector));
                break;
            default:
                throw new \Exception("Unhandled action method!");
        }
    }

    private static function autoloadRoutes() {
        $classes = ClassFinder::getClassesInNamespace(self::MAIN_NAMESPACE, ClassFinder::RECURSIVE_MODE);

        foreach ($classes as $class) {
            self::registerRoutes($class);
        }
    }
}