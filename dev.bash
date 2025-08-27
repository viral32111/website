#!/bin/bash

set -e -u -o pipefail -x

# Configuration
declare -r NGINX_CONFIGURATION_FILE_PATH="$PWD/nginx.conf"
declare -r HUGO_BUILD_DIRECTORY_PATH="$PWD/public"
declare -r DOCKER_IMAGE_CONTEXT_DIRECTORY_PATH="$PWD/context"
declare -r DOCKER_IMAGE_NAME="ghcr.io/viral32111/website"

# 1. Build the static website
if ! hugo || [[ ! -d "${HUGO_BUILD_DIRECTORY_PATH}" ]]; then
	echo "Hugo did not create build directory '${HUGO_BUILD_DIRECTORY_PATH}'!" 1>&2
	exit 1
fi

# 2. Setup the Docker context directory
if [[ -d "${DOCKER_IMAGE_CONTEXT_DIRECTORY_PATH}" ]]; then
	rm --recursive --force "${DOCKER_IMAGE_CONTEXT_DIRECTORY_PATH}"
fi
mkdir --parents "${DOCKER_IMAGE_CONTEXT_DIRECTORY_PATH}"
cp --archive "${HUGO_BUILD_DIRECTORY_PATH}" "${DOCKER_IMAGE_CONTEXT_DIRECTORY_PATH}/"
cp --archive "${NGINX_CONFIGURATION_FILE_PATH}" "${DOCKER_IMAGE_CONTEXT_DIRECTORY_PATH}/"
trap 'rm --recursive --force "${DOCKER_IMAGE_CONTEXT_DIRECTORY_PATH}"' EXIT

# 3. Build the Docker image
docker buildx build \
	--pull \
	--progress plain \
	--platform linux/amd64 \
	--file Dockerfile \
	--tag "${DOCKER_IMAGE_NAME}:local" \
	"${DOCKER_IMAGE_CONTEXT_DIRECTORY_PATH}"

# 4. Start the Docker container
docker container run \
	--name website \
	--publish published=127.0.0.1:80,target=80,protocol=tcp \
	--interactive --tty \
	--rm \
	"${DOCKER_IMAGE_NAME}:local"
