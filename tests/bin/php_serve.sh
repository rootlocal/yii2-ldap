#!/usr/bin/env sh

testDir=$(dirname $(dirname $(readlink -f "$0")))
runtime="${testDir}/runtime"
web="${testDir}/web"
php=$(which php)
pidFile="${runtime}/php.pid"
pid=""
cd ${testDir}

if [ -f "${pidFile}" ]; then
  pid=$(cat "${pidFile}")
fi

if [ ! -z ${pid} ]; then
  echo "kill ${pid}"
  kill -9 ${pid}
  rm ${pidFile}
fi

${php} -S localhost:8080 -t ${web} >"${runtime}/php.log" 2>&1 &
echo $! >"${pidFile}"
echo pid: $(cat "${pidFile}")

exit 0
