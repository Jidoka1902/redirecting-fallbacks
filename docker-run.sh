ARG=$1
docker build -t redirecting-fallbacks-docker .
docker run --name fallbacks \
        --rm \
        --volume `pwd`:/project \
        -w /project \
        redirecting-fallbacks-docker \
        $ARG