FROM alpine:latest

#Install php,nginx and supervisor
RUN apk --update add \
	php-fpm php-gd php-phalcon php-curl php-json supervisor imagemagick py-pip \
	nginx && \
	apk del build-base && \
	mkdir /tmp/nginx && \
	rm -rf /var/cache/apk/* && \
	pip install supervisor-stdout

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisor.img.ini /etc/supervisor.d/
COPY ./application/ /etc/nginx/html/img-resizer/
COPY docker/phpfpm/img.ini /etc/php/conf.d/
COPY docker/phpfpm/php-fpm.conf /etc/php/

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

EXPOSE 9000
EXPOSE 80

CMD ["/usr/bin/supervisord"]