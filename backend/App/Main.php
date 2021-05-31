<?php namespace App;


use App\Router\ExceptionHandler;
use App\Router\RestRouter;

class Main {

  public function run() {
    try {
      RestRouter::run();
    } catch (\Exception $e) {
      ExceptionHandler::handle($e);
    }
  }
}
