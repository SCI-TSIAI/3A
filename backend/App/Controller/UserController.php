<?php namespace App\Controller;

class UserController {


    public function getUsers() {
        $user = array(
            "id" => "1",
            "first_name" => "Igor",
            "last_name" => "Maculewicz"
        );


        $userJson = json_encode($user);

        echo $userJson;
    }

    public function getUser($id) {
        echo sprintf("obtained user with id: %s", $id);
    }

    public function addUser() {
        echo "added user";
    }

    public function updateUser($id) {
        echo sprintf("updated user with id: %s", $id);
    }

    public function deleteUser($id) {
        echo sprintf("deleted user with id: %s ", $id);
    }
}