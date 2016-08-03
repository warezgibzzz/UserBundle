<?php

namespace Creonit\UserBundle\Admin;

use AppBundle\Model\User;
use Creonit\AdminBundle\Component\Request\ComponentRequest;
use Creonit\AdminBundle\Component\Response\ComponentResponse;
use Creonit\AdminBundle\Component\Scope\Scope;
use Creonit\AdminBundle\Component\TableComponent;
use Creonit\UserBundle\Model\UserGroupRel;
use Creonit\UserBundle\Model\UserQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserTable extends TableComponent
{

    /**
     * @title Список пользователей
     * @cols Пользователь, Группа, Электронная почта, Телефон, .
     * @header
     *  <form class="form-inline pull-right">
     * {{ search | text({placeholder: 'Поиск по каталогу', size: 'sm'}) | group('Поиск') }}
     * {{ submit('Обновить', {size: 'sm'}) }}
     * </form>
     *
     * {{ button('Добавить пользователя', {size: 'sm', type: 'success', icon: 'user'}) | open('UserEditor') }}
     * {{ button('Группы', {size: 'sm', icon: 'folder-o'}) | open('GroupTable') }}
     * {{ button('Разрешения', {size: 'sm', icon: 'key'}) | open('RoleTable') }}
     *
     * \User
     *
     * @pagination 20
     *
     * @field group
     *
     * @col {{ title | icon('user') | open('UserEditor', {key: _key}) }}
     * @col {{ (group ? group : 'Группа не назначена') | open('UserGroupRelEditor', {key: _key}) }}
     * @col {{ email }}
     * @col {{ phone }}
     * @col {{ _delete() }}
     *
     */
    public function schema(){
    }

    /**
     * @param ComponentRequest $request
     * @param ComponentResponse $response
     * @param ParameterBag $data
     * @param User $entity
     * @param Scope $scope
     * @param $relation
     * @param $relationValue
     * @param $level
     */
    protected function decorate(ComponentRequest $request, ComponentResponse $response, ParameterBag $data, $entity, Scope $scope, $relation, $relationValue, $level)
    {
        $userGroupRels = array_map(
            function(UserGroupRel $rel){
                return $rel->getUserGroup()->getTitle();
            },
            $entity->getUserGroupRelsJoinUserGroup()->getData()
        );

        $response->data->set('group', $userGroupRels);
    }

    /**
     * @param ComponentRequest $request
     * @param ComponentResponse $response
     * @param UserQuery $query
     * @param Scope $scope
     * @param $relation
     * @param $relationValue
     * @param $level
     */
    protected function filter(ComponentRequest $request, ComponentResponse $response, $query, Scope $scope, $relation, $relationValue, $level)
    {
        if($search = $request->query->get('search')){
            dump("%{$search}%");
            $query
                ->condition('c1', 'User.Lastname LIKE ?', "%{$search}%")
                ->condition('c2', 'User.Firstname LIKE ?', "%{$search}%")
                ->condition('c3', 'User.MIddlename LIKE ?', "%{$search}%")
                ->where(['c1', 'c2', 'c3'], Criteria::LOGICAL_OR);
        }
    }


}