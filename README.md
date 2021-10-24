### Install dependencies
```shell script
$ docker run --rm -it -v $PWD:/app -w "/app" composer:2.1.9 composer install
```

### Run tests
```shell script
$ docker run --rm -it -v $PWD:/app -w "/app" php:8.0.11-cli php ./vendor/bin/phpunit
```

### Run tests with code coverage report
```shell script
$ IMAGE_TAG=$(uuidgen | tr "[:upper:]" "[:lower:]") && \

  REPORT_TARGET=./var/code-coverage && \
  FREE_PORT="$(for port in $(seq 4444 65000); do; echo -ne "\035" | telnet 127.0.0.1 $port > /dev/null 2>&1; [ $? -eq 1 ] && echo "$port" && break; done;)" && \
  REPORT_HOST=127.0.0.1:$FREE_PORT && \

  build() {
    docker build --tag=$IMAGE_TAG ./docker/php/ && \
      docker run --rm -it -v $PWD:/app -w "/app" -e XDEBUG_MODE=coverage $IMAGE_TAG \
        php ./vendor/bin/phpunit --coverage-html $REPORT_TARGET
  } && \

  cleanup() {
    docker image rm $IMAGE_TAG && \
      rm -rf $REPORT_TARGET
  } && \

  build && \

  php -S $REPORT_HOST -t $REPORT_TARGET > /dev/null 2>&1 & SERVER_PID=$! && \

  echo "\nOpen http://$REPORT_HOST to see report" && \
  echo 'Press Ctrl+C to close report' && \

  sleep 86400 & WAIT_PID=$! && \
  trap 'kill $SERVER_PID; cleanup; trap - SIGINT; kill $WAIT_PID' SIGINT ; \
  wait $WAIT_PID
```
