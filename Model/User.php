<?php


namespace Creonit\UserBundle\Model;

use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;


abstract class User implements UserInterface, EquatableInterface
{
    
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

    abstract public function getRoles();
    abstract public function getTitle();
    abstract public function getPassword();


}
