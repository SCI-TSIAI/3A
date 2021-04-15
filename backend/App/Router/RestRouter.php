<?php namespace App\Router;

use App\Group\Permission\Service\GroupPermissionService;
use App\Helpers\HttpHeadersHelper;
use App\Helpers\JwtHelper;
use App\Helpers\ReflectionUtils;
use App\Permission\Service\PermissionService;
use Bramus\Router\Router;
use HaydenPierce\ClassFinder\ClassFinder;
use ReflectionClass;
use zpt\anno\Annotations;

class RestRouter {

  const CONTROLLER_ANNOTATION_NAME = "Controller";
  const ACTION_ANNOTATION_NAME = "Action";
  const AUTHORIZED_ANNOTATION_NAME = "Authorized";
  const PATH_PARAMETER_NAME = "path";
  const PERMISSION_PARAMETER_NAME = "permission";
  const METHOD_PARAMETER_NAME = "method";
  const MAIN_NAMESPACE = "App";

  private static $router;

  /**
   * @var PermissionService
   */
  private static $permissionService;

  /**
   * @var GroupPermissionService
   */
  private static $groupPermissionService;

  /**
   * @throws \ReflectionException
   * @throws \zpt\anno\ReflectorNotCommentedException
   */
  public static function run() {

    if (empty(self::$permissionService)) {
      self::$permissionService = new PermissionService();
    }

    if (empty(self::$groupPermissionService)) {
      self::$groupPermissionService = new GroupPermissionService();
    }

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
   * @throws \Exception
   */
  private static function registerRoutes($classname) {

    $classReflector = new ReflectionClass($classname);
    $classAnnotations = new Annotations($classReflector);

    if (!$classAnnotations->hasAnnotation(self::CONTROLLER_ANNOTATION_NAME)) {
      return;
    }

    $controllerPath = isset($classAnnotations[self::CONTROLLER_ANNOTATION_NAME][self::PATH_PARAMETER_NAME])
      ? $classAnnotations[self::CONTROLLER_ANNOTATION_NAME][self::PATH_PARAMETER_NAME]
      : null;

    if (empty($controllerPath)) {
      throw new \Exception(sprintf("Path is empty in %s controller!", $classname));
    }

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

    $methodIdentifier = ReflectionUtils::getFullMethodIdentifier($methodReflector);

    $actionMethod = isset($methodAnnotations[self::ACTION_ANNOTATION_NAME][self::METHOD_PARAMETER_NAME])
      ? $methodAnnotations[self::ACTION_ANNOTATION_NAME][self::METHOD_PARAMETER_NAME]
      : null;

    if (empty($actionMethod)) {
      throw new \Exception(sprintf("Method cannot be empty in action of %s method!", $methodIdentifier));
    }

    $actionMethod = strtoupper($actionMethod);

    $actionPath = isset($methodAnnotations[self::ACTION_ANNOTATION_NAME][self::PATH_PARAMETER_NAME])
      ? $methodAnnotations[self::ACTION_ANNOTATION_NAME][self::PATH_PARAMETER_NAME]
      : null;

    $path = !empty($actionPath) ? $controllerPath . $actionPath : $controllerPath;

    if ($methodAnnotations->hasAnnotation(self::AUTHORIZED_ANNOTATION_NAME)) {

      $permission = isset($methodAnnotations[self::AUTHORIZED_ANNOTATION_NAME][self::PERMISSION_PARAMETER_NAME])
        ? $methodAnnotations[self::AUTHORIZED_ANNOTATION_NAME][self::PERMISSION_PARAMETER_NAME]
        : null;

      if (empty($permission)) {
        throw new \Exception(sprintf(
          "Authorized annotation requires permission parameter on %s method",
          $methodIdentifier
        ));
      }

      self::registerAuthorization($actionMethod, $path, $permission);
    }

    switch ($actionMethod) {
      case "GET":
        self::$router->get($path, $methodIdentifier);
        break;
      case "POST":
        self::$router->post($path, $methodIdentifier);
        break;
      case "PUT":
        self::$router->put($path, $methodIdentifier);
        break;
      case "DELETE":
        self::$router->delete($path, $methodIdentifier);
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

  private static function registerAuthorization($actionMethod, $path, $permissionName) {
    self::$router->before($actionMethod, $path, function() use ($permissionName) {
      $bearerToken = HttpHeadersHelper::getTokenForRequest();

      $isTokenValid = JwtHelper::verifyToken($bearerToken);

      $user = JwtHelper::getUserFromAuthToken();

      $permission_model = self::$permissionService->getByName($permissionName);

      $isUserHavePermission = self::$groupPermissionService->isGroupPermissionExists(
        $user->getGroupId(),
        $permission_model->getId()
      );

      if (!$isTokenValid || !$isUserHavePermission) {
        http_response_code(401);
        die();
      }
    });
  }
}
