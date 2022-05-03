<?php

namespace tests\codeception\unit\components;

use Adldap\Connections\ProviderInterface;
use Codeception\Test\Unit;
use Yii;
use yii\log\Logger;

/**
 * Class LdapTest
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package tests\codeception\unit\components
 */
class LdapTest extends Unit
{
    /** @var ProviderInterface|null */
    public ?ProviderInterface $provider = null;


    /**
     * {@inheritdoc}
     * @Override
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!extension_loaded('ldap')) {
            $this->markTestSkipped('The ldap extension is not available.');
        }

        Yii::setLogger(Yii::createObject(Logger::class));
        Yii::$app->log->setLogger(Yii::getLogger());
        Yii::getLogger()->flush();
        $this->provider = Yii::$app->ldap->getProvider();
    }

    public function testLdapConnectLdapConnect1()
    {
        $hostName = 'ldap://localhost:3389';
        $userName = 'cn=admin,dc=example,dc=com';
        $password = 'test';
        $ldap = ldap_connect($hostName);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($ldap, $userName, $password);
        $this->assertTrue(ldap_bind($ldap, $userName, $password));
    }

    public function testLdapConnectLdapConnect2()
    {
        $connect = $this->provider->connect();
        $this->assertNotEmpty($connect);
    }

    public function testLdapInsert()
    {
        $contact = $this->provider->make()->entry([
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
        $contact->setAttribute('givenName', 'za5eig2H');
        $dn = $contact->getDnBuilder();
        $dn->addCn($contact->getCommonName());
        $dn->addOu('addressbook');
        $contact->setDn($dn);

        $this->assertTrue($contact->save());
        $this->assertTrue($contact->exists);
    }

    public function testLdapSearch()
    {
        $search = $this->provider->search()->where('mail', '=', 'test@example.com')->first();
        $this->assertNotEmpty($search);
        $this->assertTrue($search->exists);
        $this->assertEquals('za5eig2H', $search->getFirstAttribute('givenName'));

        $not_found = $this->provider->search()->where('mail', '=', 'user_not_found_@example.com')->first();
        $this->assertEmpty($not_found);
    }

    public function testLdapUpdate()
    {
        $contact = $this->provider->search()->whereEquals('cn', 'Test')->first();

        $contact->fill(['mail' => 'mytest@example.com']);
        $contact->setDisplayName('Test2');
        $contact->setAttribute('givenName', 'keiVoh5k');
        $this->assertTrue($contact->save());

        $saved = $this->provider->search()->whereEquals('cn', 'Test')->first();
        $gn = $saved->getFirstAttribute('givenName');
        $this->assertEquals('keiVoh5k', $gn);
    }

    public function testLdapDelete()
    {
        $contact = $this->provider->search()->where('cn', '=', 'Test')->first();
        $this->assertTrue($contact->exists);
        $this->assertTrue($contact->delete());
        $this->assertFalse($contact->exists);

        $search = $this->provider->search()->where('cn', '=', 'Test')->get();
        $this->assertEmpty($search);
    }

}
