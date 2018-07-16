<?php

namespace rootlocal\ldap\Schemas;

/**
 * Class OpenLDAP
 * @package rootlocal\ldap\Schemas
 */
class OpenLDAP extends \Adldap\Schemas\OpenLDAP
{

    /**
     * @var OpenLDAP
     */
    private static $instance;

    /**
     * @return OpenLDAP
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}