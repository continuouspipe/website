#!/bin/bash

do_phpfpm_named_pipe() {
  if [ ! -p /var/log/php-fpm/stdout ]; then
    if [ -e /var/log/php-fpm/stdout ]; then
      rm -f /var/log/php-fpm/stdout
    fi
    mkdir -p /var/log/php-fpm/
    mkfifo -m 0660 /var/log/php-fpm/stdout
  fi
  if [ "$IN_HEROKU" != 'true' ]; then
    chown -R "$APP_USER:$APP_GROUP" /var/log/php-fpm/
  fi
}
