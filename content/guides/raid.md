---
title: "RAID"
description: "A command reference for RAID'ing disks on Linux."

date: "2026-09-19T11:25:00Z"
lastmod: "2026-09-19T11:25:00Z"

navigationBar: false
draft: false
---

# Linux RAID

Command reference for RAID array setup and management using mdadm.

## Setup

Create GPT partition table with a single `Linux RAID` partition for each disk that will be in the array.

## Create Array

The `--level` option specifies the RAID level (e.g. 0, 1, 5, etc.)

```bash
mdadm --create --name myraid --level=0 --raid-devices=2 /dev/md0 /dev/sda1 /dev/sdb1
```

## Sync Status

```bash
cat /proc/mdstat
```

## Save Configuration

```bash
mdadm --detail --scan | tee -a /etc/mdadm.conf
```

## Next Steps

The `/dev/md0` is the new RAID volume. You can format it as a filesystem, setup LVM on it, encrypt it with LUKS, etc.