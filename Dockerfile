# syntax=docker/dockerfile:1

# mkdir --verbose --parents context
# cp --verbose --archive public context/
# cp --verbose --archive nginx.conf context/
# docker buildx build --platform linux/amd64 --no-cache --pull --file Dockerfile --tag ghcr.io/viral32111/website:latest context

# Start from NGINX (Debian-based)
FROM nginx:stable

ARG HEALTHCHECK_VERSION=2.0.1 TARGETARCH
ADD --chown=0:0 --chmod=755 https://github.com/viral32111/healthcheck/releases/download/${HEALTHCHECK_VERSION}/healthcheck-linux-${TARGETARCH}-glibc /usr/local/bin/healthcheck

# Copy the static site files
COPY --chown=0:0 public /usr/share/nginx/html

# Copy the NGINX configuration file
COPY --chown=0:0 --chmod=644 nginx.conf /etc/nginx/custom.conf

# Downloads directory
VOLUME [ "/usr/share/nginx/html/download" ]

# Periodically check health
HEALTHCHECK --interval=5m --timeout=10s --start-period=5s --retries=3 CMD [ "healthcheck", "--expect", "200", "http://127.0.0.1:80" ]
