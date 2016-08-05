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