#Base Image
FROM ubuntu
#Maintainer
MAINTAINER Eric Washburn <ewashburn88@gmail.com>; 
#locale settings for Ubuntu
#RUN locale-gen en_US.UTF-8
#ENV LANG       en_US.UTF-8
#ENV LC_ALL     en_US.UTF-8 
#Install Necessary Software
RUN apt-get update -y
RUN DEBIAN_FRONTEND="noninteractive" apt-get install -y vim curl wget
RUN apt-get update -y 
#Install Apache and PHP 
RUN DEBIAN_FRONTEND="noninteractive" apt-get install -y \
php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mysql php-mbstring php-xml php-curl apache2 libapache2-mod-php
RUN a2enmod rewrite 
#Use baseimage-docker's init system.
#CMD ["/sbin/my_init"] 
#apache2 Environment Variables, and config settings
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
#ENV APACHE_PID_FILE=/var/run/apache2.pid 
#runit service files
COPY ./apache2-run.sh /etc/service/http/run 
#runit service permissions
RUN chmod +x /etc/service/http/run 
EXPOSE 80
## /apache2 
#apt-cleanup
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*