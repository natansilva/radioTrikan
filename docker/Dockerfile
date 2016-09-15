FROM ubuntu:14.04
MAINTAINER Natan Silva <natan.silva@gmail.com>

RUN apt-get update -y && \
    apt-get install -y nano && \
    apt-get install -y apache2 && \
    apt-get install -y php5 php5-cli php5-common php5-fpm


EXPOSE 80

CMD ["a2enmod", "rewrite"]
CMD ["service", "apache2", "start"]
CMD ["service", "php5.0-fpm", "start"]
