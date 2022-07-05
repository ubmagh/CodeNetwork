FROM php:7.1-apache-stretch


COPY . /usr/src/app
WORKDIR /usr/src/app
EXPOSE 80

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Hack for debian-slim to make the jdk install work below.
RUN mkdir -p /usr/share/man/man1

# repo needed for jdk install below.
RUN echo 'deb http://deb.debian.org/debian stretch-backports main' > /etc/apt/sources.list.d/backports.list

# Update image & install application dependant packages.
RUN apt-get update --fix-missing 
RUN apt-get install -y \
nano \
libxext6 \
libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev \
libmcrypt-dev \
libxslt-dev \
libpcre3-dev \
libxrender1 \
libfontconfig \
uuid-dev \
ghostscript \
curl \
wget \
ca-certificates-java \
build-essential \
g++

RUN apt-get update --fix-missing 
RUN apt-get -t stretch-backports install -y default-jdk-headless

CMD [ "php", "-t", "/usr/src/app", "-S", "0.0.0.0:80" ]

