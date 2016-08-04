<?php

namespace Creonit\UserBundle\Model;

use Creonit\UserBundle\Model\Base\UserGroupRole as BaseUserGroupRole;

/**
 * Skeleton subclass for representing a row from the 'user_group_role' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class UserGroupRole extends BaseUserGroupRole
{

    const RULE_INHERIT = 0;
    const RULE_ALLOW = 1;
    const RULE_DENY = 2;

}
