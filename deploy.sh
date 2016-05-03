# deploy under the sudo crontab on development
if [ "$#" -gt 0 -a "$1" = "Giftbox" ]
then
  cd /var/www/dev.gosizzle.io/
  BRANCH="$(git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/')"
  if [ "$BRANCH" = "develop" ]
  then
    dt=$(date '+%Y%m%d%H%M%S');
    git branch $dt.dev.backup
    git pull origin develop
  fi
fi

if [ "$#" -gt 0 -a "$1" = "Bacon" ]
then
  cd /var/www/dev.gosizzle.io/src/Bacon/
  BRANCH="$(git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/')"
  if [ "$BRANCH" = "develop" ]
  then
    dt=$(date '+%Y%m%d%H%M%S');
    git branch $dt.dev.backup
    git pull origin develop
  fi
fi
