FROM quay.io/continuouspipe/symfony-php7.2-nginx:latest
ARG GITHUB_TOKEN=
ARG SYMFONY_ENV=prod

COPY . /app/
WORKDIR /app/

RUN container build
