<?php


namespace Creonit\UserBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;


abstract class User implements UserInterface
{

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return '';
    }

    function getUsername()
    {
        return $this->getTitle();
    }

    public function eraseCredentials()
    {
    }

    abstract function getTitle();
    abstract function getPassword();


}
