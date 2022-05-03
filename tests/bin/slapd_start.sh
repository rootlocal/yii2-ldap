#!/usr/bin/env sh

testDir=$(dirname $(dirname $(readlink -f "$0")))
cd ${testDir}

add=$(which ldapadd)
param="-D cn=admin,dc=example,dc=com -w test"
dataDir="/tmp/slapd"
runtime="${testDir}/runtime"
php=$(which php)
pidFile="${runtime}/slapd.pid"
pid=""

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

if [ -f "${pidFile}" ]; then
  pid=$(cat "${pidFile}")
fi

if [ ! -z ${pid} ]; then

  if [ -n $(pgrep slapd) ]; then
    echo "kill ${pid}"
    kill -9 ${pid} >/dev/null 2>&1
    sleep 1
  fi

  rm ${pidFile}
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
echo $! >"${pidFile}"
echo pid: $(cat "${pidFile}")
sleep 1

${add} -h localhost:3389 ${param} -f ldif_data/base.ldif
${add} -h localhost:3389 ${param} -f ldif_data/INITIAL_TESTDATA.ldif
