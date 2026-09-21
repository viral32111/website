---
title: "GnuPG"
description: "Command reference for PGP key management & use."

date: "2026-09-19T11:25:00Z"
lastmod: "2026-09-19T11:25:00Z"

navigationBar: false
draft: true
---

# GnuPG

Command reference for managing GPG keys, signing, and encryption operations.

## Generate Key

```bash
$ gpg --expert --full-generate-key
```

1. Select `(9) ECC (sign and encrypt)` to use an elliptic curve with digital signing & encryption capabilities.
2. Select `(1) Curve 25519` to use the recommended curve.
3. Enter an expiry date 5 years from now (e.g., `2028-01-01`).
4. Enter your name & email address. **This is public and CANNOT be changed later.**
5. Enter a secure password to encrypt the private key with.

## List Public Keys

```bash
$ gpg --list-keys --fingerprint --keyid-format long
```

## List Private Keys

```bash
$ gpg --list-secret-keys --fingerprint --keyid-format long
```

## Trust Key

```bash
$ gpg --edit-key <key ID>
```

1. Enter `trust` in the prompt.
2. Enter `5` for ultimate trust.
3. Enter `save` to save the changes.

## Add User to Key

```bash
$ gpg --edit-key <key ID>
```

1. Enter `adduid` in the prompt.
2. Enter your name & email address. **This is public and CANNOT be changed later.**
3. Enter `save` to save the changes.

## Edit Primary User

```bash
$ gpg --edit-key <key ID>
```

1. Enter `uid <user ID>` in the prompt.
2. Enter `primary` to set this user as primary.
3. Enter `save` to save the changes.

## Export Public Key

```bash
$ gpg --armor --export <key ID>
```

## Export Private Key

```bash
$ gpg --armor --export-secret-key <key ID>
```

## Generate Revocation Certificate

```bash
$ gpg --armor --gen-revoke <key ID>
```

1. Select the reason for revocation.
2. Enter additional information.

## Sign another Key

```bash
$ gpg --local-user <my key ID> --sign-key <their key ID>
```

Export *their* public key afterwards, which is now signed.

## List Signatures

```bash
$ gpg --list-sigs --keyid-format long --fingerprint [key ID]
```

## Sign Message

```bash
$ gpg --sign --local-user <my key ID>
```

## Encrypt Message

```bash
$ gpg --armor --encrypt --recipient <their key ID>
```

## Sign & Encrypt Message

```bash
$ gpg --armor --encrypt --sign --local-user <my key ID> --recipient <their key ID>
```
