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

  runner_build() {
    docker build --tag=$IMAGE_TAG ./docker/php/
  } && \

  runner_cleanup() {
    docker image rm $IMAGE_TAG
  } && \

  report_build() {
    docker run --rm -it -v $PWD:/app -w "/app" -e XDEBUG_MODE=coverage $IMAGE_TAG \
      php ./vendor/bin/phpunit --coverage-html $REPORT_TARGET
  } && \

  report_cleanup() {
    rm -rf $REPORT_TARGET
  } && \

  runner_build && \
  report_build && \

  php -S $REPORT_HOST -t $REPORT_TARGET > /dev/null 2>&1 & \
  SERVER_PID=$! && \
  open "http://$REPORT_HOST" && \
  echo 'Press Ctrl+C to close report' && \

  cleanup() { kill $SERVER_PID; report_cleanup; runner_cleanup; trap - SIGINT; } && \
  trap cleanup SIGINT ; \
  wait $SERVER_PID
```
