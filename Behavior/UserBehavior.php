<?php

namespace Creonit\UserBundle\Behavior;

use Propel\Generator\Model\Behavior;
use Propel\Generator\Model\ForeignKey;

class UserBehavior extends Behavior
{

    protected $userTable;

    protected $userTableName = 'user';

    public function modifyDatabase()
    {
        $this->addUserTable();
    }

    protected function addUserTable(){
        if(null !== $this->userTable){
            return;
        }

        $database = $this->getDatabase();
        $tableName  = $this->userTableName;

        if ($database->hasTable($tableName)) {
            $table = $this->userTable = $database->getTable($tableName);

        } else {
            $table = $this->userTable = $database->addTable(['name' => $tableName]);
            $table->setPackage($database->getPackage());
            $table->addColumn(['name' => 'id', 'type' => 'integer', 'primaryKey' => true, 'autoIncrement' => true]);
        }

        if(!$table->hasColumn('password')){
            $table->addColumn(['name' => 'password', 'type' => 'varchar', 'size' => 64, 'required' => true]);
        }

        if(!$table->hasColumn('salt')) {
            $table->addColumn(['name' => 'salt', 'type' => 'varchar', 'size' => 64, 'required' => true]);
        }

        $table->addBehavior(new UserExtendsBehavior);

        foreach ($this->database->getBehaviors() as $behavior) {
            $behavior->modifyDatabase();
        }
    }


}