<?php


namespace App\User\Service;


use App\Database\Entity\Entity;
use App\Database\Entity\EntityMapper;
use App\Helpers\Model\TokenObject;
use App\Helpers\ObjectMapper;
use App\Serializer\JsonSerializer;
use App\User\Entity\UserEntity;
use App\User\Model\UserRequest;
use App\User\Model\UserModel;
use App\User\Repository\UserRepository;

class UserService {

    const USER_GROUP_ID = 1;

    private $userRepository;

    /**
     * UserService constructor.
     */
    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function createUser(UserRequest $request) {

        $userEntity = new UserEntity();

        $userEntity->setUsername($request->getUsername())
            ->setPasswordHash(sha1($request->getPassword()))
            ->setGroupId(self::USER_GROUP_ID);

        return ObjectMapper::map(
          $this->userRepository->save($userEntity),
          UserModel::class
        );
    }

    /**
     * @param $id
     * @return object
     */
    public function getUser($id) {
        return ObjectMapper::map(
            $this->userRepository->getById($id),
            UserModel::class
        );
    }

    public function getAuthenticatedUser($username, $password) {
        return $this->userRepository->getUserByUsernameAndPassword($username, $password);
    }

    public function deleteUser($id, TokenObject $tokenObject) {
        //TODO Later when we change $userId to user object from token, check that user is in admin group.

        if ($id !== $tokenObject->getUserId()) {
            throw new \Exception("User does not have access to given resource");
        }

        $deletedRowsCount = $this->userRepository->delete($id);

        if ($deletedRowsCount == 0) {
            throw new \Exception(sprintf("Failed user deletion with id: %d", $id));
        }
    }
}
