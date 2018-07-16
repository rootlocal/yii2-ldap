<?php

namespace tests\codeception\unit\components;

use tests\codeception\unit\TestCase;
use Codeception\Util\Fixtures;
use Yii;

/**
 * Class LdapTest
 * @package tests\codeception\unit\components
 */
class LdapTest extends TestCase
{
    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();
        if (!extension_loaded('ldap')) {
            $this->markTestSkipped('The ldap extension is not available.');
        }
    }

    public function testLdapConnect()
    {
        $hostName = 'ldap://localhost:3389';
        $userName = 'cn=admin,dc=example,dc=com';
        $password = 'test';
        $ldap = ldap_connect($hostName);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($ldap, $userName, $password);
        $this->assertTrue(ldap_bind($ldap, $userName, $password));
    }

    public function testLdapSearch()
    {
        $search = Yii::$app->ldap->provider->search()
            ->where('mail', '=', 'te@example.com')
            ->get();
        $this->assertTrue(!empty($search));
    }

}
