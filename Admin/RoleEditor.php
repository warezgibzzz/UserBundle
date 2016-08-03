<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\EditorComponent;
use Creonit\AdminBundle\Component\Request\ComponentRequest;
use Creonit\AdminBundle\Component\Response\ComponentResponse;

class RoleEditor extends EditorComponent
{

    /**
     * @title Разрешение
     * @entity \Creonit\UserBundle\Model\UserRole
     * @field title {required: true}
     * @field name {required: true}
     * @field group_id:external {title: 'entity.getUserRoleGroup().getTitle()', required: true}
     * @template
     * 
     * {{ title | text | group('Название') }}
     * {{ name | text | group('Идентификатор') }}
     * {{ group_id | external('ChooseRoleGroupTable') | group('Секция') }}
     *
     */
    public function schema(){
    }

    public function decorate(ComponentRequest $request, ComponentResponse $response, $entity)
    {
        if($relation = $request->query->get('relation')){
            $field = $this->getField('group_id');
            $entity->setGroupId($relation);
            $response->data->set($field->getName(), $field->load($entity));
        }
    }


}