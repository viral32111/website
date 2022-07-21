# Security

As alluded to on the [home page](/home), the software that runs this web server, [NGINX](https://nginx.org) and [Apache HTTP Server](https://httpd.apache.org/), are both configured to enforce modern security standards.

While this website at present has no need for such security, as there is no user information or credentials exchanged, I find it is always good practice to ensure excellent security for any project I undertake, especially when it involves connections to the Internet.

## Protocols

The [Transport Layer Security (TLS)](https://en.wikipedia.org/wiki/Transport_Layer_Security) protocol is used to ensure all data exchanged between your device and this webserver is protected from malicious interception and tampering. It is a successor to the flawed [Secure Sockets Layer (SSL)](https://en.wikipedia.org/wiki/Transport_Layer_Security#SSL_1.0,_2.0,_and_3.0) protocol.

There are a few versions of this protocol, of which this server will accept version 1.2 and 1.3, the latter is preferred. This server will deny versions 1.0 and 1.1 due to their vulnerabilities and wide-spread deprecation. Similarly, this server will deny all versions of the SSL protocol, including 1.0, 2.0 and 3.0.

### HTTPS

A common misconception is that website traffic is secured with the HTTPS "protocol", this is however not true (to an extent). HTTPS is just an extension to the existing [HTTP protocol](https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol) that only changes the [scheme in URLs](https://en.wikipedia.org/wiki/URL#Syntax) and [Transmission Control Protocol (TCP)](https://en.wikipedia.org/wiki/Transmission_Control_Protocol) port number. The underlying encryption is performed with TLS or SSL.

## Ciphers

This server's OpenSSL cipher suite preference is configured as `ECDHE:!ECDHE-ECDSA-AES256-SHA384:!ECDHE-ECDSA-CAMELLIA256-SHA384:!ECDHE-ECDSA-AES128-SHA256:!ECDHE-ECDSA-CAMELLIA128-SHA256:HIGH:!MEDIUM:!LOW:!aNULL:!eNULL:!SHA1:!MD5:!TLSv1.0:!SSLv3:!EXP`.

This priorities [EC](https://en.wikipedia.org/wiki/Elliptic-curve_cryptography) ciphers that support [Perfect Forward Secrecy (PFS)](https://en.wikipedia.org/wiki/Forward_secrecy) and TLS 1.3 ciphers using AES-GCM and CHACHA20-POLY1305 algorithms with 256-bit keys. It removes support for all protocols, ciphers and hashes considered weak (`LOW`, `SHA1`, `MD5`, `TLSv1.0`, `SSLv3`), without authentication (`aNULL`), or without encryption (`eNULL`). It also removes all export ciphers (`EXP`).

Fast ciphers are not prioritised as it is not necessary on a website this minimal.

## Headers

While HTTP headers do not improve the strength of the underlying cryptography, they do instruct browsers to restrict functionality to minimise the attack surface. The following headers are used:

* [`Content-Security-Policy`](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP) prevents loading content that is not authorised by this website.
* [`X-XSS-Protection`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection) prevents rendering the page if a [cross-site scripting attack](https://owasp.org/www-community/attacks/xss/) is detected.
* [`X-Frame-Options`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options) prevents framing this website on other websites.
* [`X-Content-Type-Options`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options) prevents requests for unexpected content types.
* [`Referrer-Policy`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy) prevents informing other websites that you came from this website.
* [`Strict-Transport-Security`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security) enforces encrypted requests to this website for future visits.

As an additional benefit to the last header, this website is in the [HSTS Preload List](https://hstspreload.org/?domain=viral32111.com) to ensure all modern web browsers know to only ever visit this website over HTTPS.

## Cookies

This website sets a single session [cookie](https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies) on your browser. This cookie uses the following attributes for improved security:

* [`SameSite`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite) prevents the browser from sending the cookie to websites.
* [`HttpOnly`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#httponly) prevents clientside scripts from reading the cookie.
* [`Secure`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#secure) ensures the cookie is only sent when HTTPS is in use.

See the [cookie policy](/legal/cookie-policy) for more information about this cookie.

## JavaScript

This website does not require JavaScript to function, so it is safe to disable it if that is desired.

Syntax highlighting for code blocks using the [Highlight.js](https://highlightjs.org/) library is the only feature where JavaScript is present. These code blocks will simply lack syntax highlighting if it is disabled.

[Subresource integrity](https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity) and the [`Content-Security-Policy`](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP) HTTP header are used to mitigate the possibility of your web browser loading a malicious script.

## Server

I own the physical server that runs this web server, it is not hosted by a third-party provider, thus I have absolute control over it.

The server runs in-memory, so temporary data such as caches and runtime files are never written to disk. The only data kept on disk is the configuration files for the web server and logs for requests, responses and errors. Those logs are kept for 90 days then permanently erased.

Strong disk encryption is utilised to ensure that nothing can be read if the physical server is ever compromised.

## Yourself

This is what your web browser is using when sending requests to this website.

* [SNI](https://www.cloudflare.com/en-gb/learning/ssl/what-is-sni/): `<?= apache_request_headers()[ 'X-SSL-Name' ] ?? 'Unknown' ?>`
* Protocol: `<?= apache_request_headers()[ 'X-SSL-Protocol' ] ?? 'Unknown' ?>`
* Cipher: `<?= apache_request_headers()[ 'X-SSL-Cipher' ] ?? 'Unknown' ?>`
* Elliptic Curve: `<?= apache_request_headers()[ 'X-SSL-Curve' ] ?? 'Unknown' ?>`
* Request Scheme: `<?= apache_request_headers()[ 'X-Forwarded-Proto' ] ?? 'Unknown' ?>`
* TCP Port: `<?= apache_request_headers()[ 'X-Forwarded-Port' ] ?? 'Unknown' ?>`

Your [SSL session identifier](https://nginx.org/en/docs/http/ngx_http_ssl_module.html#var_ssl_session_id) is `<?= apache_request_headers()[ 'X-SSL-Session' ] ?? 'Unknown' ?>`.
