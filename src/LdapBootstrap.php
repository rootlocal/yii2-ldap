<?php

namespace rootlocal\ldap;

use yii\base\BootstrapInterface;

/**
 * Class LdapBootstrap
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\ldap
 */
class LdapBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // add module I18N category
        if (!isset($app->i18n->translations['ldap'])) {
            $app->i18n->translations['ldap'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@rootlocal/ldap/messages',
            ];
        }
    }
}