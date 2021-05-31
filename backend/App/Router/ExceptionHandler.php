<?php


namespace App\Router;


use App\Helpers\ObjectMapper;
use App\Serializer\JsonSerializer;
use App\User\Exception\NotFoundException;

class ExceptionHandler {


  public static function handle(\Exception $exception) {

    $httpCode = 200;

    switch (true) {
      case $exception instanceof NotFoundException:
        $httpCode = 404;
        break;
    }

    http_response_code($httpCode);
    $errorResponse = new ErrorResponse($exception->getMessage());

    die(JsonSerializer::getInstance()->serialize($errorResponse, "json"));
  }
}
