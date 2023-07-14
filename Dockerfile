# syntax=docker/dockerfile:1

# Start from NGINX (Debian based)
FROM nginx:stable

# Copy the static site files
COPY --chown=0:0 public /usr/share/nginx/html

# Copy the NGINX configuration file
COPY --chown=0:0 --chmod=644 nginx.conf /etc/nginx/custom.conf
