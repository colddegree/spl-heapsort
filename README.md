### Install dependencies
```shell script
$ docker run --rm -it -v $PWD:/app -w "/app" composer:2.1.9 composer install
```

### Run tests
```shell script
$ docker run --rm -it -v $PWD:/app -w "/app" php:8.0.11-cli php ./vendor/bin/phpunit
```
