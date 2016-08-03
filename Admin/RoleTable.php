<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\TableComponent;

class RoleTable extends TableComponent
{

    /**
     * @title Список разрешений
     * @cols Название, Идентификатор, .
     * @header
     * {{ button('Добавить секцию', {size: 'sm', type: 'success', icon: 'folder-o'}) | open('RoleEditor') }}
     * {{ button('Добавить разрешение', {size: 'sm', type: 'success', icon: 'key'}) | open('RoleEditor') }}
     *
     * \RoleGroup
     * @entity \Creonit\UserBundle\Model\UserRoleGroup
     * @sortable true
     * @col {{ title | icon('folder-o') | open('RoleGroupEditor', {key: _key}) | controls( button('', {size: 'xs', icon: 'key'}) | open('RoleEditor', {relation: _key}) ) }}
     * @col
     * @col {{ _delete() }}
     *
     * \Role
     * @entity \Creonit\UserBundle\Model\UserRole
     * @sortable true
     * @relation group_id > RoleGroup.id
     * @field name
     * @col {{ title | icon('key') | open('RoleEditor', {key: _key}) | controls }}
     * @col {{ 'ROLE_' ~ name | upper }}
     * @col {{ _delete() }}
     *
     */
    public function schema(){
    }


}