# syntax=docker/dockerfile:1

# docker buildx build --progress plain --file ./Dockerfile --tag ghcr.io/viral32111/website:latest --pull ./

# Start from my Apache image
FROM registry.server.home/apache:latest

# Configure directories (should match the Apache image)
ARG APACHE_CONFIG_DIRECTORY=/etc/apache
ARG APACHE_WEB_DIRECTORY=/var/www

# Add the website files
COPY --chown=1000:1000 ./website ${APACHE_WEB_DIRECTORY}/website

# Add the configuration files
COPY --chown=0:0 ./config/virtualhost.conf ${APACHE_CONFIG_DIRECTORY}/hosts/website.conf
COPY --chown=0:0 ./config/website.conf ${APACHE_CONFIG_DIRECTORY}/website.conf
COPY --chown=0:0 ./config/environment.conf ${APACHE_CONFIG_DIRECTORY}/environment.conf

# Install required PEAR/PECL extensions
RUN apt-get update && \
	apt-get install --no-install-recommends --yes \
		build-essential autoconf \
		libgpgme11 libgpgme-dev && \
	pecl install redis gnupg && \
	apt-get remove --autoremove --purge --yes \
		build-essential autoconf \
		libgpgme-dev && \
	apt-get clean --yes && \
	rm --verbose --recursive \
		/tmp/pear \
		/var/lib/apt/lists/*

# Change to the website directory
WORKDIR ${APACHE_WEB_DIRECTORY}/website
