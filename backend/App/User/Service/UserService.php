<?php


namespace App\User\Service;


use App\Database\Entity\Entity;
use App\Database\Entity\EntityMapper;
use App\Serializer\JsonSerializer;
use App\User\Entity\UserEntity;
use App\User\Model\AddUserRequest;
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

    public function createUser(AddUserRequest $request) {

        $userEntity = new UserEntity();

        $userEntity->setUsername($request->getUsername())
            ->setPasswordHash(sha1($request->getUsername()))
            ->setGroupId(self::USER_GROUP_ID);

        return EntityMapper::mapEntityToResponse(
            $this->userRepository->save($userEntity),
            UserModel::class
        );
    }

    /**
     * @param $id
     * @return object
     */
    public function getUser($id) {
        return EntityMapper::mapEntityToResponse(
            $this->userRepository->getById($id),
            UserModel::class
        );
    }
}