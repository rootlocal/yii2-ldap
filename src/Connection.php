<?php

namespace rootlocal\ldap;

use Adldap\Connections\Ldap;

/**
 * Class Connection
 * @package rootlocal\ldap
 */
class Connection extends Ldap
{
    
    /**
     * @var Connection
     */
    private static $instance;

    /**
     * @return Connection
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}