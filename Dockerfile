# syntax=docker/dockerfile:1

# Start from NGINX (Debian-based)
FROM nginx:stable

ARG HEALTHCHECK_VERSION=2.0.1 HEALTHCHECK_ARCHITECTURE=
ADD --chown=0:0 --chmod=755 https://github.com/viral32111/healthcheck/releases/download/${HEALTHCHECK_VERSION}/healthcheck-linux-${HEALTHCHECK_ARCHITECTURE}-glibc /usr/local/bin/healthcheck

# Copy the static site files
COPY --chown=0:0 public /usr/share/nginx/html

# Copy the NGINX configuration file
COPY --chown=0:0 --chmod=644 nginx.conf /etc/nginx/custom.conf

# Downloads directory
VOLUME [ "/usr/share/nginx/html/download" ]
