---
title: "OpenSSL"
description: "Command reference for SSL/TLS operations."

date: "2026-09-19T11:25:00Z"
lastmod: "2026-09-19T11:25:00Z"

navigationBar: false
draft: true
---

# OpenSSL

Reference for SSL/TLS certificate operations. This is not meant to be comprehensive—just personal notes.

## Subject Fields (`subj` parameter)

| Short Name | Long Name | Description |
| ---------- | --------- | ----------- |
| `CN` | `commonName` | The primary domain name (or anything for a CA certificate) |
| `C` | | The country |
| `ST` | | The state/county |
| `L` | | The city |
| `O` | `organizationName` | The organisation's name |
| `OU` | | The organisation's department name ([may be deprecated soon](https://www.globalsign.com/en/blog/globalsign-deprecate-ou-field-tls-certificates)) |
| | `emailAddress` | A contact email address |

## RSA

### Generate Private Key

RSA 4096-bit key with AES-256 encryption.

```bash
openssl genrsa -out private.pem -aes256 4096
```

### Generate Self-Signed Certificate

```bash
openssl req -x509 -key ca/private.pem -out ca/certificate.pem -days 365 -sha512 -subj "/O=Certificate Authority/CN=example.com/emailAddress=certificates@example.com" -addext "subjectAltName=DNS:*.example.com" -verbose
```

### Generate Certificate Signing Request

```bash
openssl req -new -key org/private.pem -out org/request.csr -sha512 -subj "/O=Organisation/CN=example.com/emailAddress=certificates@example.com" -verbose
```

### Sign Certificate Request

(This is for renewal too)

```bash
openssl x509 -req -CA ca/certificate.pem -CAkey ca/private.pem -CAserial ca/serial.srl -CAcreateserial -in org/request.csr -out org/certificate.pem -days 365 -sha512 -extfile <(printf "subjectAltName=DNS:example.com,DNS:*.example.com,IP:123.123.123.123")
```

### Display Private Key

```bash
openssl req -in private.pem -noout -text
```

### Display Certificate

```bash
openssl x509 -in certificate.pem -noout -text
```

### Display Certificate Signing Request

```bash
openssl req -in request.csr -noout -text
```

## EC

### Generate Intermediary Private Key

```bash
openssl ecparam -genkey -name secp521r1 -out int/private.pem
```

### Create Intermediary Certificate Request

```bash
openssl req -new -key int/private.pem -out int/request.csr -sha512 -subj "/commonName=Example/organizationName=Example/emailAddress=certificates@example.com" -verbose
```

### Sign Intermediary Certificate Request

(With existing CA, this is for renewal too)

```bash
openssl x509 -req -CA ca/certificate.pem -CAkey ca/private.pem -CAserial ca/serial.srl -CAcreateserial -in int/request.csr -out int/certificate.pem -days 365 -sha512 -extfile <( printf "basicConstraints=critical,CA:true,pathlen:0\nkeyUsage=critical,digitalSignature,keyCertSign,cRLSign\nextendedKeyUsage=serverAuth\nsubjectKeyIdentifier=hash" )
```

### Generate Final Private Key

```bash
openssl ecparam -genkey -name secp521r1 -out org/private.pem
```

### Create Final Certificate Request

```bash
openssl req -new -key private.pem -out org/request.csr -sha512 -subj "/commonName=example.com/organizationName=Example/emailAddress=certificates@example.com" -verbose
```

### Sign Final Certificate Request

(This is for renewal too)

```bash
openssl x509 -req -CA int/certificate.pem -CAkey int/private.pem -CAserial int/serial.srl -CAcreateserial -in org/request.csr -out org/certificate.pem -days 365 -sha512 -extfile <( printf "basicConstraints=CA:false\nkeyUsage=critical,digitalSignature\nextendedKeyUsage=serverAuth\nsubjectKeyIdentifier=hash\nsubjectAltName=DNS:example.com,DNS:*.example.com,IP:123.123.123.123" )
```

## Encrypting existing private keys

### RSA

```bash
openssl rsa -aes256 -in private.pem -out private.pem.enc
```

### EC

```bash
openssl ec -aes256 -in private.pem -out private.pem.enc
```
