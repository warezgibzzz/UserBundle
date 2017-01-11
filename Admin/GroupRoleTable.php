<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\Request\ComponentRequest;
use Creonit\AdminBundle\Component\Response\ComponentResponse;
use Creonit\AdminBundle\Component\Scope\Scope;
use Creonit\AdminBundle\Component\TableComponent;
use Creonit\UserBundle\Model\UserGroup;
use Creonit\UserBundle\Model\UserGroupQuery;
use Creonit\UserBundle\Model\UserGroupRole;
use Creonit\UserBundle\Model\UserGroupRoleQuery;
use Creonit\UserBundle\Model\UserRole;
use Creonit\UserBundle\Model\UserRoleQuery;
use Symfony\Component\HttpFoundation\ParameterBag;

class GroupRoleTable extends TableComponent
{

    /** @var  UserGroup */
    protected $group;

    /**
     * @title Список разрешений
     * @cols Разрешение, Идентификатор, ., .
     * @header
     * {{ button('Добавить секцию', {size: 'sm', type: 'success', icon: 'folder-o'}) | open('RoleGroupEditor') }}
     * {{ button('Добавить разрешение', {size: 'sm', type: 'success', icon: 'key'}) | open('RoleEditor') }}
     *
     * @action choose(group, role, rule){
     *      this.request('choose', {group: group, role: role}, {rule: rule});
     *      this.loadData();
     * }
     *
     * \RoleGroup
     * @entity \Creonit\UserBundle\Model\UserRoleGroup
     * @sortable true
     * @col {{ title | icon('folder-o') | open('RoleGroupEditor', {key: _key}) | controls( button('', {size: 'xs', icon: 'key'}) | open('RoleEditor', {relation: _key}) ) }}
     * @col
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
     * @col {{ buttons(
     *     button('', {size: 'xs', icon: 'check-circle-o', type: rule == 1 ? 'success' : 'default'}) | action('choose', _query.group, _key, 1) ~
     *     button('', {size: 'xs', icon: 'ban', type: rule == 2 ? 'danger' : 'default'}) | action('choose', _query.group, _key, 2) ~
     *     button('', {size: 'xs', icon: 'circle-o', type: rule == 0 ? (rule_deep == 1 ? 'success' : 'danger') : 'default'}) | action('choose', _query.group, _key, 0)
     * ) }}
     * @col {{ _delete() }}
     *
     */
    public function schema(){

        $this->setHandler('choose', function (ComponentRequest $request, ComponentResponse $response) {
            $group = UserGroupQuery::create()->findPk($request->query->get('group')) or $response->flushError('Группа не найдена');

            if($request->query->has('group')){
                $role = UserRoleQuery::create()->findPk($request->query->get('role')) or $response->flushError('Разрешение не найдено');
                if(!$rel = UserGroupRoleQuery::create()->filterByUserGroup($group)->filterByUserRole($role)->findOne()){
                    $rel = new UserGroupRole();
                    $rel->setUserGroup($group);
                    $rel->setUserRole($role);
                }

                $rel->setRule($request->data->getInt('rule'));
                $rel->save();

            }

        });

    }

    protected function decorate(ComponentRequest $request, ComponentResponse $response, ParameterBag $data, $entity, Scope $scope, $relation, $relationValue, $level)
    {
        if($scope->getName() == 'Role'){
            /** @var UserRole $entity */
            $data->set('rule', $this->group->getRoleRule($entity));
            $data->set('rule_deep', $ruleDeep = $this->group->getRoleRule($entity, true));
            if($ruleDeep === UserGroupRole::RULE_ALLOW){
                $data->set('_row_class', 'success');
            }
        }
    }

    protected function loadData(ComponentRequest $request, ComponentResponse $response)
    {
        $this->group = UserGroupQuery::create()->findPk($request->query->get('group'));
        parent::loadData($request, $response);
    }


}