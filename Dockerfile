# syntax=docker/dockerfile:1

# Start from NGINX (Debian-based)
FROM nginx:stable

# Download my healthcheck utility
ARG HEALTHCHECK_VERSION=2.0.1 TARGETPLATFORM
RUN apt-get update && \
	apt-get install --no-install-recommends --yes wget && \
	case "${TARGETPLATFORM}" in \
		"linux/amd64") ARCHITECTURE="amd64" ;; \
		"linux/arm64") ARCHITECTURE="arm64" ;; \
		*) echo "Unrecognised target platform: '${TARGETPLATFORM}'!" && exit 1 ;; \
	esac && \
	wget --no-hsts --progress dot:mega --output-document /usr/local/bin/healthcheck https://github.com/viral32111/healthcheck/releases/download/${HEALTHCHECK_VERSION}/healthcheck-linux-${ARCHITECTURE}-glibc && \
	chmod 755 /usr/local/bin/healthcheck && \
	apt-get purge --auto-remove --yes wget && \
	apt-get clean --yes && \
	rm --verbose --recursive /var/lib/apt/lists/*

# Copy the static site files
COPY --chown=0:0 public /usr/share/nginx/html

# Copy the NGINX configuration file
COPY --chown=0:0 --chmod=644 nginx.conf /etc/nginx/custom.conf

# Downloads directory
VOLUME [ "/usr/share/nginx/html/download" ]
