<?php

namespace rootlocal\ldap;

use rootlocal\ldap\Schemas\OpenLDAP;
use yii\base\Component;
use Adldap\Adldap;
use Adldap\Auth\BindException;
use yii\base\Exception;

/**
 * Class Ldap
 * @package rootlocal\ldap
 *
 * @property \Adldap\Connections\ProviderInterface $provider
 */
class Ldap extends Component
{
    /**
     * @var array
     */
    public $domain_controllers;

    /**
     * @var string
     */
    public $port;

    /**
     * @var integer
     */
    public $version;

    /**
     * @var string
     */
    public $base_dn;

    /**
     * @var string
     */
    public $admin_username;

    /**
     * @var string
     */
    public $admin_password;

    /**
     * The default provider name
     * @var string
     */
    public $providerName = 'default';

    /**
     * @var Adldap
     */
    private $_adLdap;


    /**
     * Ldap constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->_adLdap = $this->getAdLdap()->addProvider(
            $config,
            $this->providerName,
            $this->getConnection(),
            OpenLDAP::getInstance()
        );
    }

    /**
     * @return Adldap
     */
    public function getAdLdap()
    {
        if (empty($this->_adLdap)) {
            $this->_adLdap = new Adldap();
        }

        return $this->_adLdap;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return Connection::getInstance();
    }

    /**
     * @return \Adldap\Connections\ProviderInterface
     * @throws Exception
     */
    public function getProvider()
    {
        try {
            $provider = $this->_adLdap->connect();
            return $provider;
        } catch (BindException $e) {
            throw new Exception($e->getTrace(), $e->getCode());
        }
    }
}