---
title: "LUKS"
description: "Command reference for Linux disk encryption using cryptsetup."

date: "2026-09-19T11:25:00Z"
lastmod: "2026-09-21T18:42:00Z"

navigationBar: false
draft: false
---

This is a command reference for setting up and managing LUKS disk encryption on Linux systems using [the `cryptsetup` utility](https://man.archlinux.org/man/cryptsetup.8.en).

## ![Hourglass](/images/icons/hourglass.png)Benchmark

Performing an initial benchmark on your system is ideal to determine the fastest cipher and key size combination for your hardware.

```shell
cryptsetup benchmark
```

Broadly speaking, `aes-xts` with a key size of 256 or 512 bits benchmarks well on modern hardware:

| Algorithm | Key size | Encryption   | Decryption   |
| --------- | -------- | ------------ | ------------ |
| aes-xts   | 256 bits | 9252.6 MiB/s | 9233.9 MiB/s |
| aes-xts   | 512 bits | 8600.7 MiB/s | 8611.8 MiB/s |
| aes-cbc   | 128 bits | 1864.5 MiB/s | 7386.3 MiB/s |
| aes-cbc   | 256 bits | 1424.6 MiB/s | 6031.6 MiB/s |

## ![Lock](/images/icons/lock.png)Setup

Formatting a block device for LUKS will erase all existing data. Ensure all important data is backed up before proceeding.

```shell
cryptsetup luksFormat --verbose --type luks2 --cipher aes-xts-plain64 --key-size 512 --hash sha512 --pbkdf argon2id --iter-time 2000 --pbkdf-memory 1048576 --verify-passphrase /dev/sdXX
```

When choosing `xts`, the key size should be doubled due to the use of two internal keys. For example, 256 bits + 256 bits = 512 bits, which is equivalent to AES-256.

Overwriting the block device with random data before formatting it can make encrypted data indistinguishable from unused blocks, a common approach for doing this on hard drives is using `shred --iterations 1 /dev/sdXX`. For solid state drives (including NVMe), prefer the vendor's secure erase utility.

## ![Key](/images/icons/key.png)Passphrase

To add an additional passphrase for unlocking the block device:

```shell
cryptsetup luksAddKey --verbose --hash sha512 --pbkdf argon2id --iter-time 2000 --pbkdf-memory 1048576 --verify-passphrase /dev/sdXX
```

To remove an existing passphrase for unlocking the block device (enter the passphrase to be removed when prompted):

```shell
cryptsetup luksRemoveKey --verbose /dev/sdXX
```

To remove an existing passphrase for unlocking the block device by its key slot number instead:
```shell
cryptsetup luksKillSlot --verbose /dev/sdXX <SLOT_NUMBER>
```

To test whether a passphrase can successfully unlock the block device:

```shell
cryptsetup luksOpen --test-passphrase /dev/sdXX
```

## ![Drive CD](/images/icons/drive_cd.png)Access

Mounting an unlocked block device requires it to be properly formatted with a standard filesystem (e.g. `mkfs.ext4 /dev/mapper/LUKS_NAME`)

```shell
cryptsetup luksOpen /dev/sdXX LUKS_NAME
mount /dev/mapper/LUKS_NAME /mnt/mountpoint_name
```

To unmount and remove the mapping for the unlocked block device, perform the reverse of the operation above:

```shell
umount /mnt/mountpoint_name
cryptsetup luksClose LUKS_NAME
```

## ![Compress](/images/icons/compress.png)Backup

It is important to have a safe copy of the block device's LUKS header in case it becomes corrupted or key slots unexpectedly change.

```shell
cryptsetup luksHeaderBackup --header-backup-file /safe/place/for/luks-header-backup /dev/sdXX
```

A human-readable description of the LUKS information can be obtained using:

```shell
cryptsetup luksDump /dev/sdXX
```
