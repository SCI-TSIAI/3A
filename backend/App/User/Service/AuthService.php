<?php


namespace App\User\Service;

use App\Helpers\JwtHelper;
use App\User\Group\Service\UserGroupService;
use App\User\Model\Token;

class AuthService {

  private $userService;
  private $userGroupService;

  /**
   * AuthService constructor.
   */
  public function __construct() {
    $this->userService = new UserService();
    $this->userGroupService = new UserGroupService();
  }

  public function login($username, $password) {

    $authenticatedUser = $this->userService->getAuthenticatedUser($username, $password);

    if (!empty($authenticatedUser)) {
      $user_group = $this->userGroupService->getUserGroup($authenticatedUser);

      $tokenString = JwtHelper::generateUserToken(
        $authenticatedUser->getId(),
        $authenticatedUser->getUsername(),
        $user_group->getId()
      );

      return new Token($tokenString);
    }

    return null;
  }
}
