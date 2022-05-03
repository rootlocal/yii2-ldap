<?php

namespace rootlocal\ldap;

use Adldap\Connections\ConnectionInterface;
use Adldap\Connections\ProviderInterface;
use rootlocal\ldap\Schemas\OpenLDAP;
use yii\base\Component;
use Adldap\Adldap;

/**
 * Class Ldap
 *
 * @property-read Connection $connection
 * @property-read Adldap $adLdap
 * @property ProviderInterface $provider
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\ldap
 */
class Ldap extends Component
{
    /**
     * @var array
     * @deprecated use $hosts
     */
    public array $domain_controllers = [];
    /**
     * An array of your LDAP hosts.
     * You can use either the host name or the IP address of your host.
     * @var array
     */
    public array $hosts = [];
    /** @var int The port to use for connecting to your hosts */
    public int $port = ConnectionInterface::PORT;
    /** @var int The LDAP version to utilize */
    public int $version;
    /**
     * The base distinguished name of your domain to perform searches upon
     * @var string|null
     */
    public ?string $base_dn = null;
    /**
     * @var string|null
     * @deprecated use $username
     */
    public ?string $admin_username = null;
    /** @var string|null */
    public ?string $username = null;
    /**
     * @var string|null
     * @deprecated use password
     */
    public ?string $admin_password;
    /** @var string|null */
    public ?string $password;
    /**
     * The default provider name
     * @var string
     */
    public string $providerName = 'default';

    /** @var Adldap|null */
    private ?Adldap $_adLdap;


    /**
     * Ldap constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        if (isset($config['admin_password']) && !empty($config['admin_password'])) {
            $config['password'] = $config['admin_password'];
            unset($config['admin_password']);
        }
        if (isset($config['admin_username']) && !empty($config['admin_username'])) {
            $config['username'] = $config['admin_username'];
            unset($config['admin_username']);
        }
        if (isset($config['domain_controllers']) && !empty($config['domain_controllers'])) {
            $config['hosts'] = $config['domain_controllers'];
            unset($config['domain_controllers']);
        }

        $this->_adLdap = $this->getAdLdap()->addProvider(
            /** @see \Adldap\Configuration\DomainConfiguration */
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
    public function getConnection(): Connection
    {
        return Connection::getInstance();
    }

    /**
     * @return ProviderInterface
     */
    public function getProvider(): ProviderInterface
    {
        return $this->_adLdap->connect();
    }
}