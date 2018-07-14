#!/usr/bin/env bash

killall slapd
rm ldapconfig.ini
rm -R /tmp/slapd
mkdir /tmp/slapd

cat ldapconfig.ini.dist | sed s/389/3389/ > ldapconfig.ini
/usr/local/opt/openldap/libexec/slapd -f ldif_data/slapd_macos.conf -h ldap://localhost:3389 -d 256 &
sleep 3
ldapadd -h localhost:3389 -D cn=admin,dc=example,dc=com -w test -f ldif_data/base.ldif
ldapadd -h localhost:3389 -D cn=admin,dc=example,dc=com -w test -f ldif_data/INITIAL_TESTDATA.ldif