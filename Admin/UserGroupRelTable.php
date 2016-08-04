<?php

namespace Creonit\UserBundle\Admin;

use AppBundle\Model\UserQuery;
use Creonit\AdminBundle\Component\Request\ComponentRequest;
use Creonit\AdminBundle\Component\Response\ComponentResponse;
use Creonit\AdminBundle\Component\Scope\Scope;
use Creonit\AdminBundle\Component\TableComponent;
use Creonit\UserBundle\Model\UserGroupQuery;
use Creonit\UserBundle\Model\UserGroupRel;
use Creonit\UserBundle\Model\UserGroupRelQuery;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserGroupRelTable extends TableComponent
{

    protected $rels;

    /**
     * @title Группы пользователя
     * @cols Название группы, Разрешения, Идентификатор, .
     * @header 
     * {{ button('Добавить группу', {size: 'sm', type: 'success', icon: 'users'}) | open('GroupEditor') }}
     *
     * @action choose(user, group, rowId){
     *      var $row = this.findRowById(rowId).toggleClass('success')
     *      this.request('choose', {user: user, group: group}, {state: $row.hasClass('success')});
     *      this.parent.loadData();
     * }
     *
     * \Group
     * @entity \Creonit\UserBundle\Model\UserGroup
     * @relation parent_id > Group.id
     * @sortable true
     *
     * @col {{ title | icon('users') | action('choose', _query.user, _key, _row_id) | controls(buttons(
     *    button('', {size: 'xs', icon: 'pencil'}) | open('GroupEditor', {key: _key}) ~
     *    button('', {size: 'xs', icon: 'users'}) | open('GroupEditor', {relation: _key})
     * )) }}
     * @col {{ 'Разрешения' | icon('key') | open('GroupRoleTable', {group: _key}) }}
     * @col {{ name }}
     * @col {{ _delete() }}
     * 
     */
    public function schema(){
        $this->setHandler('choose', function (ComponentRequest $request, ComponentResponse $response) {
            $user = UserQuery::create()->findPk($request->query->get('user')) or $response->flushError('Пользователь не найден');

            if($request->query->has('group')){
                $group = UserGroupQuery::create()->findPk($request->query->get('group')) or $response->flushError('Группа не найдена');
                $rel = UserGroupRelQuery::create()->filterByUser($user)->filterByUserGroup($group)->findOne();
                if($request->data->getBoolean('state')){
                    if(!$rel){
                        $rel = new UserGroupRel();
                        $rel->setUser($user);
                        $rel->setUserGroup($group);
                        $rel->save();
                    }
                }else{
                    if($rel){
                        $rel->delete();
                    }
                }

            }

        });
    }

    protected function decorate(ComponentRequest $request, ComponentResponse $response, ParameterBag $data, $entity, Scope $scope, $relation, $relationValue, $level)
    {
        if(in_array($entity->getId(), $this->rels)){
            $data->set('_row_class', 'success');
        }
    }


    protected function loadData(ComponentRequest $request, ComponentResponse $response)
    {
        $this->rels = UserGroupRelQuery::create()->filterByUserId($request->query->getInt('user'))->select('GroupId')->find()->getData();
        parent::loadData($request, $response);
    }


}