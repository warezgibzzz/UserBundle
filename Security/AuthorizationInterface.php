<?php

namespace Creonit\UserBundle\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface AuthorizationInterface
{

    public function loadUserByUsername($username);
    public function loadUserByOAuthUserResponse(UserResponseInterface $response);
    public function refreshUser(UserInterface $user);
    public function supportClass($class);
    
}