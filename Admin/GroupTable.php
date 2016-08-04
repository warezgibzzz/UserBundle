<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\Request\ComponentRequest;
use Creonit\AdminBundle\Component\Response\ComponentResponse;
use Creonit\AdminBundle\Component\Scope\Scope;
use Creonit\AdminBundle\Component\TableComponent;
use Creonit\UserBundle\Model\UserGroup;
use Symfony\Component\HttpFoundation\ParameterBag;

class GroupTable extends TableComponent
{

    /**
     * @title Список групп пользователей
     * @cols Название, Разрешения, Идентификатор, .
     * @header
     * {{ button('Добавить группу', {size: 'sm', type: 'success', icon: 'users'}) | open('GroupEditor') }}
     *
     * \UserGroup
     * @entity Creonit\UserBundle\Model\UserGroup
     * @relation parent_id > UserGroup.id
     * @sortable true
     * @col {{ title | icon('users') | open('GroupEditor', {key: _key}) | controls( button('', {size: 'xs', icon: 'users'}) | open('GroupEditor', {relation: _key}) ) }}
     * @col {{ 'Разрешения' | icon('key') | open('GroupRoleTable', {group: _key}) }}
     * @col {{ name }}
     * @col {{ _delete() }}
     *
     */
    public function schema(){
    }


}