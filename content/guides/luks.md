---
title: "Cryptsetup"
description: "Reference for disk encryption with LUKS using cryptsetup."

date: "2026-09-19T11:25:00Z"
lastmod: "2026-09-19T11:25:00Z"

navigationBar: false
draft: false
---

# Cryptsetup

Command reference for LUKS disk encryption operations.

## Benchmark Ciphers

```bash
cryptsetup benchmark
```

## Setup

**NOTE:** When using XTS, key size should be doubled due to the use of two internal keys (e.g. 512-bits is 256-bits).

**NOTE:** Remember to fill the drive with random data before setup to make encrypted data indistinguishable from unused blocks (e.g. `shred -n 1 /dev/sdXX`).

```bash
cryptsetup luksFormat --verbose --type luks2 --cipher aes-xts-plain64 --key-size 512 --hash sha512 --pbkdf pbkdf2 --iter-time 2000 --verify-passphrase /dev/sdXX
```

## Add Passphrase

```bash
cryptsetup luksAddKey --verbose --hash sha512 --pbkdf pbkdf2 --iter-time 2000 --verify-passphrase /dev/sdXX
```

## Remove Passphrase

```bash
cryptsetup luksRemoveKey --verbose /dev/sdXX
```

## Test Passphrase

```bash
cryptsetup luksOpen --test-passphrase /dev/sdXX
```

## Open & Mount

**NOTE:** Requires having the mapping already formatted as a standard filesystem (e.g. `mkfs.ext4 /dev/mapper/YYYY`)

```bash
cryptsetup luksOpen /dev/sdXX YYYY
mount /dev/mapper/YYYY /mnt/ZZZZ
```

## Unmount & Close

```bash
umount /mnt/ZZZZ
cryptsetup luksClose YYYY
```

## View Information

```bash
cryptsetup luksDump /dev/sdXX
```