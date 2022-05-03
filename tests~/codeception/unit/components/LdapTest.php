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

    public function testLdapConnect1()
    {
        $hostName = 'ldap://localhost:3389';
        $userName = 'cn=admin,dc=example,dc=com';
        $password = 'test';
        $ldap = ldap_connect($hostName);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($ldap, $userName, $password);
        $this->assertTrue(ldap_bind($ldap, $userName, $password));
    }


    public function testLdapConnect2()
    {
        $connect = Yii::$app->ldap->provider->connect();
        $this->assertTrue(!empty($connect));
    }

    public function testLdapInsert()
    {
        $contact = \Yii::$app->ldap->provider->make()->entry([
            'objectClass' => [
                'inetOrgPerson',
                'organizationalPerson',
                'person',
                'top',
            ],
            'cn' => 'Test',
            'sn' => 'Test test',
        ]);

        $contact->setDisplayName('Snoop Einstein');
        $contact->setAttribute('mail', 'test@example.com');
        $dn = $contact->getDnBuilder();
        $dn->addCn($contact->getCommonName());
        $dn->addOu('addressbook');
        $contact->setDn($dn);

        $this->assertTrue($contact->save());
    }

    public function testLdapSearch()
    {
        $search = Yii::$app->ldap->provider->search()
            ->where('mail', '=', 'test@example.com')
            ->get();
        $this->assertTrue(!empty($search));
    }

    public function testLdapUpdate()
    {
        $contact = Yii::$app->ldap->provider->search()
            ->whereEquals('cn', 'Test')->first();

        $contact->fill(['mail' => 'mytest@example.com']);
        $contact->setDisplayName('Test2');
        $this->assertTrue($contact->save());
    }

    public function testLdapDelete()
    {
        $contact = Yii::$app->ldap->provider->search()
            ->where('cn', '=', 'Test')
            ->first();

        $this->assertTrue($contact->delete());
    }

}
