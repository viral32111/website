# syntax=docker/dockerfile:1

# Start from NGINX (Debian-based)
FROM nginx:stable

ARG HEALTHCHECK_VERSION=2.0.1 TARGETARCH
ADD --chown=0:0 --chmod=755 https://github.com/viral32111/healthcheck/releases/download/${HEALTHCHECK_VERSION}/healthcheck-linux-${TARGETARCH}-glibc /usr/local/bin/healthcheck

# Copy the static site files
COPY --chown=0:0 public /usr/share/nginx/html

# Copy the NGINX configuration file
COPY --chown=0:0 --chmod=644 nginx/server.conf /etc/nginx/conf.d/default.conf
COPY --chown=0:0 --chmod=644 nginx/headers.conf /etc/nginx/headers.conf

# Downloads directory
ARG DOWNLOAD_DIRECTORY_PATH=/var/lib/download
RUN mkdir -v -p ${DOWNLOAD_DIRECTORY_PATH} && \
	chown 1000:1000 ${DOWNLOAD_DIRECTORY_PATH} && \
	chmod 755 ${DOWNLOAD_DIRECTORY_PATH}

VOLUME ${DOWNLOAD_DIRECTORY_PATH}

# Periodically check health
HEALTHCHECK --interval=5m --timeout=10s --start-period=5s --retries=3 CMD [ "healthcheck", "--expect", "200", "http://127.0.0.1:80/status" ]
