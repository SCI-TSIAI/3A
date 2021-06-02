<?php


namespace App\Router;


use App\Helpers\ObjectMapper;
use App\Router\Exception\BadRequestException;
use App\Serializer\JsonSerializer;
use App\User\Exception\InternalServerErrorException;
use App\User\Exception\NotFoundException;

class ExceptionHandler {


  public static function handle(\Exception $exception) {

    switch (true) {
      case $exception instanceof NotFoundException:
        $httpCode = 404;
        break;
      case $exception instanceof BadRequestException:
        $httpCode = 400;
        break;
      default:
        $httpCode = 500;
    }

    http_response_code($httpCode);
    $errorResponse = new ErrorResponse($exception->getMessage());

    die(JsonSerializer::getInstance()->serialize($errorResponse, "json"));
  }
}
