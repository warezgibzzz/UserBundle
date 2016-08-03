<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Module;

class UserModule extends Module
{

    protected function configure()
    {
        $this
            ->setTitle('Пользователи')
            ->setIcon('user')
            ->setTemplate('UserTable')
        ;
    }

    public function initialize()
    {
        $this->addComponent(new UserTable);
        $this->addComponent(new UserEditor);
        
        $this->addComponent(new GroupTable);
        $this->addComponent(new GroupEditor);
        $this->addComponent(new ChooseGroupTable);

        $this->addComponent(new RoleTable);
        $this->addComponent(new RoleEditor);
        $this->addComponent(new RoleGroupEditor);
        $this->addComponent(new ChooseRoleGroupTable);
    }
}