<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\EditorComponent;
use Creonit\AdminBundle\Component\Request\ComponentRequest;
use Creonit\AdminBundle\Component\Response\ComponentResponse;

class GroupEditor extends EditorComponent
{
    /**
     * @title Группа
     * @entity Creonit\UserBundle\Model\UserGroup
     * @field title {required: true}
     * @field name {required: true}
     * @field parent_id:external {title: 'entity.getParent().getTitle()'}
     * @template
     *
     * {{ title | text | group('Название') }}
     * {{ name | text | group('Идентификатор') }}
     * {{ parent_id | external('ChooseGroupTable', {empty: 'Без родительской группы', query: {key: _key} }) | group('Родительская группа') }}
     *
     */
    public function schema(){
    }

    
    public function decorate(ComponentRequest $request, ComponentResponse $response, $entity)
    {
        if($relation = $request->query->get('relation')){
            $field = $this->getField('parent_id');
            $entity->setParentId($relation);
            $response->data->set($field->getName(), $field->load($entity));
        }
    }


}