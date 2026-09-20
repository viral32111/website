---
title: "Arch Linux"
description: "Setup guide for Arch Linux installation with LUKS encryption, LVM, and complete system configuration."

date: "2026-09-19T11:25:00Z"
lastmod: "2026-09-19T11:25:00Z"

navigationBar: false
draft: false
---

# Arch Linux Setup

A comprehensive reference for installing and configuring Arch Linux, including encrypted partitions and logical volume management.

## 0. Set keyboard & console font

```bash
loadkeys uk
setfont ter-118n
```

## 1. Set timezone

```bash
timedatectl set-timezone Europe/London
```

## 2. Define useful variables

```bash
export DRIVE=/dev/nvme1n1
export BOOT_PARTITION=/dev/nvme1n1p1
export LUKS_PARTITION=/dev/nvme1n1p2
export ROOT_PARTITION=/dev/vg0/root
export SWAP_PARTITION=/dev/vg0/swap

export LUKS_NAME=luks0
export LVM_NAME=vg0
export LVM_ROOT_NAME=root
export LVM_SWAP_NAME=swap
```

## 3. Wipe existing data

```bash
wipefs --all $BOOT_PARTITION || true
wipefs --all $LUKS_PARTITION || true
wipefs --all $DRIVE
```

## 4. Setup partitions

```bash
# Setup GPT with 4GB EFI system partition & remaining as generic Linux filesystem partition
cfdisk $DRIVE
```

## 5. Format boot partition

```bash
mkfs.fat -F 32 -n BOOT $BOOT_PARTITION
```

## 6. Format LUKS partition

```bash
cryptsetup luksFormat --verbose --type luks2 --cipher aes-xts-plain64 --key-size 512 --hash sha512 --pbkdf pbkdf2 --iter-time 5000 --verify-passphrase $LUKS_PARTITION
cryptsetup luksAddKey --verbose --hash sha512 --pbkdf pbkdf2 --iter-time 5000 --verify-passphrase $LUKS_PARTITION
cryptsetup open $LUKS_PARTITION $LUKS_NAME
```

## 7. Setup LVM on LUKS partition

```bash
pvcreate /dev/mapper/$LUKS_NAME
vgcreate $LVM_NAME /dev/mapper/$LUKS_NAME
lvcreate -L 32G -n $LVM_SWAP_NAME $LVM_NAME
lvcreate -l 100%FREE -n $LVM_ROOT_NAME $LVM_NAME
```

## 8. Format LVM volumes

```bash
mkfs.ext4 -L ROOT $ROOT_PARTITION
mkswap -L SWAP $SWAP_PARTITION
```

## 9. Mount filesystems

```bash
mount --mkdir $ROOT_PARTITION /mnt
mount --mkdir $BOOT_PARTITION /mnt/boot
```

## 10. Install base packages

```bash
# Set the '--country' flag to 'GB'
nano /etc/xdg/reflector/reflector.conf
systemctl start reflector

pacstrap -K /mnt base linux linux-firmware intel-ucode dosfstools e2fsprogs efibootmgr cryptsetup lvm2 nano dhcpcd ethtool bind traceroute reflector terminus-font
```

## 11. Enter the new system

```
genfstab -U /mnt >> /mnt/etc/fstab
arch-chroot /mnt
```