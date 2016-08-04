<?php

namespace Creonit\UserBundle\Admin;

use Creonit\AdminBundle\Component\EditorComponent;

class UserEditor extends EditorComponent
{
    /**
     * @title Пользователь
     * @entity User
     * @template
     * {{ lastname | text | group('Фамилия') }}
     * {{ firstname | text | group('Имя') }}
     * {{ middlename | text | group('Отчество') }}
     *
     */
    public function schema(){
    }
}