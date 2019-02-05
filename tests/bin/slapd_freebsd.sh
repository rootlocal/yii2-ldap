#!/usr/bin/env bash

command="/usr/local/libexec/slapd"
add=$(which ldapadd)
slapdPid=$(pgrep slapd)
param="-D cn=admin,dc=example,dc=com -w test"
dataDir="/tmp/slapd"

if [ -n "${slapdPid}" ]; then
    echo "kill \"${slapdPid}\""
    kill ${slapdPid} > /dev/null 2>&1 
fi

if [ -f "ldapconfig.ini" ]; then
    echo "remove \"ldapconfig.ini\""
    rm ldapconfig.ini > /dev/null 2>&1
fi

if [ -d "${dataDir}" ]; then
    echo "remove \"${dataDir}\""
    rm -R ${dataDir} > /dev/null 2>&1
fi

mkdir ${dataDir}
cat ldapconfig.ini.dist | sed s/389/3389/ > ldapconfig.ini
${command} -f ldif_data/slapd_macos.conf -h ldap://localhost:3389 -d 256 &

sleep 3

${add} -h localhost:3389 ${param} -f ldif_data/base.ldif
${add} -h localhost:3389 ${param} -f ldif_data/INITIAL_TESTDATA.ldif
