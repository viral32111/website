#!/bin/sh

# Configure directories in the container, these should match the virtual-host configuration!
DIRECTORY_CERTIFICATES="/etc/certificates"
DIRECTORY_CONFIG="/etc/apache"
DIRECTORY_WEBSITE="/var/www/website"
DIRECTORY_LOG="/var/log/website"

# Create a new Docker container
docker container create \
	--name website \
	--memory 1024M \
	--tmpfs ${DIRECTORY_LOG}:uid=1000,gid=1000,mode=755 \
	--mount type=bind,source=$HOME/certificates/viral32111.local,target=${DIRECTORY_CERTIFICATES},readonly \
	--mount type=bind,source=$PWD/config/virtualhost.conf,target=${DIRECTORY_CONFIG}/hosts/website.conf,readonly \
	--mount type=bind,source=$PWD/config/website.conf,target=${DIRECTORY_CONFIG}/website.conf,readonly \
	--mount type=bind,source=$PWD/config/environment.conf,target=${DIRECTORY_CONFIG}/environment.conf,readonly \
	--mount type=bind,source=$PWD/website,target=${DIRECTORY_WEBSITE},readonly \
	--hostname website \
	--publish published=127.0.0.1:80,target=80,proto=tcp \
	--publish published=127.0.0.1:443,target=443,proto=tcp \
	--restart no \
	ghcr.io/viral32111/website:latest
