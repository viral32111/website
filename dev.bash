#!/bin/bash

set -e -u -o pipefail -x

# Configuration
declare -r DOMAIN="viral32111.local"
declare -r DOCKER_IMAGE="ghcr.io/viral32111/website:local"
declare -r HUGO_OUTPUT_DIRECTORY_PATH="$PWD/public"
declare -r HUGO_ASSETS_DIRECTORY_PATH="$PWD/assets"

# Generate the syntax highlighting CSS - https://gohugo.io/quick-reference/syntax-highlighting-styles/
declare -r THEME_NAME="friendly"
declare -r THEME_MODE="light"
hugo gen chromastyles --style=${THEME_NAME} --mode=${THEME_MODE} > "${HUGO_ASSETS_DIRECTORY_PATH}/stylesheets/chromastyles.${THEME_NAME}.${THEME_MODE}.css"

# Clean up the output directory
if [[ -d "${HUGO_OUTPUT_DIRECTORY_PATH}" ]]; then
	rm -r -f "${HUGO_OUTPUT_DIRECTORY_PATH}"
	mkdir -v -p "${HUGO_OUTPUT_DIRECTORY_PATH}"
fi

# Build the website into the output directory
if ! hugo --baseURL "https://${DOMAIN}" --buildDrafts --buildExpired --buildFuture --destination "${HUGO_OUTPUT_DIRECTORY_PATH}" || [[ ! -d "${HUGO_OUTPUT_DIRECTORY_PATH}" ]]; then
	echo "Hugo failed to build into output directory '${HUGO_OUTPUT_DIRECTORY_PATH}'!" 1>&2
	exit 1
fi

# Build the Docker image
docker buildx build \
	--pull \
	--progress plain \
	--file Dockerfile \
	--tag "${DOCKER_IMAGE}" \
	"$PWD"

# Generate self-signed TLS certificates
declare -r TLS_DIRECTORY_PATH=".tls"
declare -r TLS_PRIVATE_KEY_PATH="${TLS_DIRECTORY_PATH}/private.pem"
declare -r TLS_CERTIFICATE_PATH="${TLS_DIRECTORY_PATH}/certificate.pem"
if [[ ! -d "${TLS_DIRECTORY_PATH}" ]]; then
	mkdir -v -p "${TLS_DIRECTORY_PATH}"
fi
if [[ ! -f "${TLS_PRIVATE_KEY_PATH}" || ! -f "${TLS_CERTIFICATE_PATH}" ]]; then
	mkcert -key-file "${TLS_PRIVATE_KEY_PATH}" -cert-file "${TLS_CERTIFICATE_PATH}" localhost 127.0.0.1 ${DOMAIN}
fi

# Create the download directory
declare -r DOWNLOAD_DIRECTORY_PATH="$PWD/download"
if [[ ! -d "$PWD/download" ]]; then
	mkdir -v -p "$PWD/download"
fi

# Start the Docker container
docker container run \
	--name ${DOMAIN} \
	--publish published=127.0.0.1:80,target=80,protocol=tcp \
	--publish published=127.0.0.1:443,target=443,protocol=tcp \
	--publish published=127.0.0.1:443,target=443,protocol=udp \
	--mount "type=bind,source=${TLS_DIRECTORY_PATH},target=/usr/local/share/tls,readonly" \
	--mount "type=bind,source=${DOWNLOAD_DIRECTORY_PATH},target=/var/lib/download,readonly" \
	--interactive --tty \
	--rm \
	"${DOCKER_IMAGE}"
