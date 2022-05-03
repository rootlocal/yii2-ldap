<?php

namespace rootlocal\ldap\Schemas;

/**
 * Class OpenLDAP
 *
 * @property-read OpenLDAP $instance
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\ldap\Schemas
 */
class OpenLDAP extends \Adldap\Schemas\OpenLDAP
{
    /** @var OpenLDAP */
    private static $instance;


    /**
     * @return OpenLDAP
     */
    public static function getInstance(): OpenLDAP
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}