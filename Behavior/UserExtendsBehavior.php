<?php

namespace Creonit\UserBundle\Behavior;

use Propel\Generator\Model\Behavior;

class UserExtendsBehavior extends Behavior
{

    public function parentClass($builder){
        if(preg_match('/(\w+)$/', $builder->getClassname(), $match)){
            switch($match[1]){
                case 'User':
                    return '\Creonit\UserBundle\Model\User';
                case 'UserQuery':
                    return '\Creonit\UserBundle\Model\UserQuery';
            }
        }
    }
    
}