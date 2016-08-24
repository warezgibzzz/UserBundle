public function getGroupTitles($implode = false){
    return $this->cache(__METHOD__, function() use ($implode){
        $groupRels = array_map(
            function(UserGroupRel $rel){
                return $rel->getUserGroup()->getTitle();
            },
            $this->getUserGroupRelsJoinUserGroup()->getData()
        );

        return false !== $implode ? implode(true === $implode ? ', ' : $implode, $groupRels) : $groupRels;
    });

}

public function getRoles(){
    return $this->cache(__METHOD__, function(){
        $roles = ['ROLE_USER'];
        $roleIds = [];

        foreach($this->getUserGroupRels() as $groupRel){
            foreach(\Creonit\UserBundle\Model\UserRoleQuery::create()->find() as $role){
                if(
                    !in_array($role->getId(), $roleIds) and
                    $rule = $groupRel->getUserGroup()->getRoleRule($role, true) and
                    $rule === \Creonit\UserBundle\Model\UserGroupRole::RULE_ALLOW
                ){
                    $roleIds[] = $role->getId();
                    $roles[] = 'ROLE_' . strtoupper($role->getName());
                }
            }
        }
        return $roles;
    });
}


public function setGroup($groups, $consist = null){
    if($this->isNew())
        throw new \Exception('Save item before use setGroup()');

    if($groups instanceof \Creonit\UserBundle\Model\UserGroup)
        $groups = array($groups->getId());

    if(!is_array($groups))
        $groups = array($groups);

    if($consist !== null){

        foreach($groups as $group_id){
            $rel = \Creonit\UserBundle\Model\UserGroupRelQuery::create()->filterByUserId($this->getId())->filterByGroupId($group_id)->findOne();

            if($consist){
                if(!$rel){
                    $rel = new \Creonit\UserBundle\Model\UserGroupRel();
                    $rel->setUserId($this->getId());
                    $rel->setGroupId($group_id);
                    $rel->save();
                }
            }else{
                if($rel)
                    $rel->delete();
            }
        }

    }else{

        $groups_ex = array();
        foreach($this->getUserGroupRels() as $rel){
            if(in_array($rel->getGroupId(), $groups)){
                $groups_ex[] = $rel->getGroupId();
            }else{
                $rel->delete();
            }
        }

        foreach(array_diff($groups, $groups_ex) as $group_id){
            $rel = new \Creonit\UserBundle\Model\UserGroupRel();
            $rel->setUserId($this->getId());
            $rel->setGroupId($group_id);
            $rel->save();
        }

    }

    return $this;
}