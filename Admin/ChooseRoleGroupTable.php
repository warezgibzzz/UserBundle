<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\TableComponent;

class ChooseRoleGroupTable extends TableComponent
{

    /**
     * @title Выберите секцию
     * @cols Название

     * \RoleGroup
     * @entity \Creonit\UserBundle\Model\UserRoleGroup
     * @col {{ title | icon('folder-o') | action('external', _key, title) }}
     *
     */
    public function schema(){
    }
}