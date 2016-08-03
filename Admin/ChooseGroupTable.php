<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\Request\ComponentRequest;
use Creonit\AdminBundle\Component\Response\ComponentResponse;
use Creonit\AdminBundle\Component\Scope\Scope;
use Creonit\AdminBundle\Component\TableComponent;
use Propel\Runtime\ActiveQuery\Criteria;

class ChooseGroupTable extends TableComponent
{

    /**
     * @title Выберите группу
     * @cols Название, Идентификатор
     *
     * \UserGroup
     * @entity Creonit\UserBundle\Model\UserGroup
     * @relation parent_id > UserGroup.id
     * @col {{ title | icon('folder-o') | action('external', _key, title) | controls }}
     * @col {{ name }}
     *
     */
    public function schema(){
    }

    protected function filter(ComponentRequest $request, ComponentResponse $response, $query, Scope $scope, $relation, $relationValue, $level)
    {
        if($key = $request->query->get('key')){
            $query->filterById($key, Criteria::NOT_EQUAL);
        }
    }


}