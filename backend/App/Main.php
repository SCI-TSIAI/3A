<?php namespace App;


use App\Router\RestRouter;

class Main {

    public function run() {
        RestRouter::run();
    }
}