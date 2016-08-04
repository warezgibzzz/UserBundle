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