<?php

namespace Creonit\UserBundle\Model;

use Creonit\UserBundle\Model\Base\UserGroup as BaseUserGroup;

/**
 * Skeleton subclass for representing a row from the 'user_group' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class UserGroup extends BaseUserGroup
{

    public function getRoleRule($roleName, $deep = false)
    {
        if(!$roleName instanceof UserRole){
            if(!$role = UserRole::get($roleName)){
                return UserGroupRole::RULE_DENY;
            }
        }else{
            $role = $roleName;
        }

        if($rel = UserGroupRoleQuery::create()->filterByUserGroup($this)->filterByUserRole($role)->findOne()){
            if(true === $deep){
                if(UserGroupRole::RULE_INHERIT === $rel->getRule()){
                    if($this->parent_id){
                        return $this->getParent()->getRoleRule($role, true);
                    }else{
                        return UserGroupRole::RULE_DENY;
                    }
                }else{
                    return $rel->getRule();
                }
            }else{
                return $rel->getRule();
            }

        }else{
            if(true === $deep){
                if($this->parent_id){
                    return $this->getParent()->getRoleRule($role, true);
                }else{
                    return UserGroupRole::RULE_DENY;
                }
            }else{
                return UserGroupRole::RULE_INHERIT;
            }
        }



    }
    
}
