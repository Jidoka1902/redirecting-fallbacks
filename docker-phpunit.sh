docker build -t redirecting-fallbacks-docker .
docker run --name fallbacks \
        --rm \
        --volume `pwd`:/project \
        -w /project \
        redirecting-fallbacks-docker \
        /bin/sh -c "composer install; php vendor/bin/phpunit --config phpunit.xml"