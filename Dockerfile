# syntax=docker/dockerfile:1

# Start from NGINX (Debian-based)
FROM nginx:stable

# Get the target architecture
ARG TARGETPLATFORM
RUN case "${TARGETPLATFORM}" in \
		"linux/amd64") ARCHITECTURE="amd64" ;; \
		"linux/arm64") ARCHITECTURE="arm64" ;; \
		*) echo "Unrecognised target platform: '${TARGETPLATFORM}'!" && exit 1 ;; \
	esac

# Download my healthcheck utility
ARG HEALTHCHECK_VERSION=2.0.1
ADD --chown=0:0 --chmod=755 https://github.com/viral32111/healthcheck/releases/download/${HEALTHCHECK_VERSION}/healthcheck-linux-${ARCHITECTURE}-glibc /usr/local/bin/healthcheck

# Copy the static site files
COPY --chown=0:0 public /usr/share/nginx/html

# Copy the NGINX configuration file
COPY --chown=0:0 --chmod=644 nginx.conf /etc/nginx/custom.conf

# Downloads directory
VOLUME [ "/usr/share/nginx/html/download" ]
