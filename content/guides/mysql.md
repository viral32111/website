---
title: "MySQL"
description: "Command reference for MySQL database administration."

date: "2026-09-19T11:25:00Z"
lastmod: "2026-09-19T11:25:00Z"

navigationBar: false
draft: true
---

# MySQL

Command reference for MySQL user and privilege management.

## Create User

Adds a new user for connecting to the database server.

```sql
CREATE USER 'name'@'host' IDENTIFIED BY 'password';
```

Use a different authentication plugin for compatibility with some applications.

```sql
CREATE USER 'name'@'host' IDENTIFIED WITH 'mysql_native_password' BY 'password';
```

## Delete User

Removes an existing user.

```sql
DROP USER 'name'@'host';
```

## Rename User

Changes a user's name or host, and maintains grants.

```sql
RENAME USER 'user'@'host' TO 'user'@'host';
```

## List Users

Shows all of the existing users.

```sql
SELECT User,Host,plugin FROM mysql.user;
```

## Update User Password

Changes the password for an existing user.

```sql
ALTER USER 'name'@'host' IDENTIFIED BY 'password';
```

## Grant Privileges

Add permissions to an existing user.

```sql
GRANT ALL PRIVILEGES ON database.table TO 'name'@'host';
```

Individual permissions can also be specified.

```sql
GRANT SELECT, UPDATE, INSERT, DELETE ON database.table TO 'name'@'host';
```

## Revoke Privileges

Remove permissions from an existing user.

```sql
REVOKE ALL PRIVILEGES ON database.table FROM 'name'@'host';
```

Individual permissions can also be specified.

```sql
REVOKE SELECT, UPDATE, INSERT, DELETE on database.table from 'name'@'host';
```

## List User Privileges

Shows all of the permissions for an existing user.

```sql
SHOW GRANTS FOR 'name'@'host';
```
