#!/usr/bin/env sh

testDir=$(dirname $(dirname $(readlink -f "$0")))
cd ${testDir}

add=$(which ldapadd)
slapdPid=$(pgrep slapd)
param="-D cn=admin,dc=example,dc=com -w test"
dataDir="/tmp/slapd"
runtime="${testDir}/runtime"

command="/usr/sbin/slapd"
ldapConfig="ldif_data/slapd_linux.conf"

OS="$(uname)"
case $OS in
'Linux')
  OS='Linux'
  command="/usr/sbin/slapd"
  ldapConfig="ldif_data/slapd_linux.conf"
  ;;
'FreeBSD')
  OS='FreeBSD'
  command="/usr/local/libexec/slapd"
  ldapConfig="ldif_data/slapd_macos.conf"
  ;;
'WindowsNT')
  OS='Windows'
  ;;
'Darwin')
  OS='Mac'
  command="/usr/local/opt/openldap/libexec/slapd"
  ldapConfig="ldif_data/slapd_macos.conf"
  ;;
'SunOS')
  OS='Solaris'
  ;;
'AIX') ;;
*) ;;
esac

if [ -n "${slapdPid}" ]; then
  echo "kill ${slapdPid}"
  kill ${slapdPid} >/dev/null 2>&1
fi

if [ -f "ldapconfig.ini" ]; then
  echo "remove ldapconfig.ini"
  rm ldapconfig.ini >/dev/null 2>&1
fi

if [ -d "${dataDir}" ]; then
  echo "remove ${dataDir}"
  rm -R ${dataDir} >/dev/null 2>&1
fi

mkdir ${dataDir}
cat ldapconfig.ini.dist | sed s/389/3389/ >ldapconfig.ini
${command} -f ${ldapConfig} -h ldap://localhost:3389 -d 256 >"${runtime}/slap.log" 2>&1 &

sleep 2

${add} -h localhost:3389 ${param} -f ldif_data/base.ldif
${add} -h localhost:3389 ${param} -f ldif_data/INITIAL_TESTDATA.ldif
