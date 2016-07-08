<?php

namespace Creonit\UserBundle\Model;

use Creonit\UserBundle\Model\Base\UserSign as BaseUserSign;

class UserSign extends BaseUserSign
{

    /**
     * @param string $provider email, phone or name of OAuth2 provider
     * @param string $username
     * @param null|User $user
     * @return UserSign
     */
    public static function get($provider, $username, $user = null, $enabled = null){
        return UserSignQuery::create()
            ->filterByProvider($provider)
            ->filterByUsername($username)
                ->_if(null !== $user)
                    ->filterByUser($user)
                ->_endif()
                ->_if(null !== $enabled)
                    ->filterByEnabled($enabled)
                ->_endif()
            ->findOne();
    }

}
