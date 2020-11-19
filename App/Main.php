<?php namespace App;

use App\User\Repository\UserRepository;

class Main {

    public function run() {
        $userRepository = new UserRepository();

        $x = $userRepository->findById(1);
    }
}