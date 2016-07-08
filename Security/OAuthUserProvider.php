<?php

namespace Creonit\UserBundle\Security;


use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;

class OAuthUserProvider implements OAuthAwareUserProviderInterface
{
    protected $authorization;

    public function __construct(AuthorizationInterface $authorization)
    {
        $this->authorization = $authorization;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response){
        return $this->authorization->loadUserByOAuthUserResponse($response);
    }

}