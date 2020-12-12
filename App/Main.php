<?php namespace App;

use App\User\Entity\UserEntity;
use App\User\Repository\UserRepository;

class Main {

    public function run() {
        $userRepository = new UserRepository();


        $x = new UserEntity();

        $x->setPasswordHash("dsasdaa");
        $x->setUsername("dasdsa");
        $x->setGroupId(1);
        $x->setLastLogin(date("Y-m-d H:i:s"));

        $result = $userRepository->save($x);

        $userRepository->save($result);

        //TODO Add constraints to our schema(E.g. For username in user table).
    }
}