FROM httpd:2.2

MAINTAINER Maksym Maksymenko "fubolg.ua@gmail.com"

###
### Installation
###

# required packages
RUN set -x \
	&& apt-get update \
	&& apt-get upgrade -y \
	&& apt-get install --no-install-recommends --no-install-suggests -y \
		autoconf \
		gcc \
		vim \
		make \
		python-yaml \
		supervisor \
		wget \
	&& rm -rf /var/lib/apt/lists/* \
	&& apt-get purge -y --auto-remove

# mod-proxy-fcgi
RUN set -x \
	&& wget --no-check-certificate -O mod-proxy-fcgi.tar.gz https://github.com/devilbox/mod-proxy-fcgi/archive/master.tar.gz \
	&& tar xvfz mod-proxy-fcgi.tar.gz \
	&& cd mod-proxy-fcgi-master \
	&& autoconf \
	&& ./configure \
	&& make \
	&& make install \
	&& cd .. \
	&& rm -rf mod-proxy-fcgi*