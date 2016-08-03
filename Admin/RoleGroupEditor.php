<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\EditorComponent;

class RoleGroupEditor extends EditorComponent
{

    /**
     * @title Секция
     * @entity \Creonit\UserBundle\Model\UserRoleGroup
     * @field title {required: true}
     * @template
     * 
     * {{ title | text | group('Название') }}
     */
    public function schema(){
    }
    
}