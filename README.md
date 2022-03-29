# Overview

    Project Name: MySQL Query Monitor
    Description: based on general_log

# System Requirements

    PHP v7.0 or higher
    MySQL v5.5 or higher

## Required PHP modules

    filter
    pdo
    pdo_mysql

# Installation

```sh
git clone git@github.com:dtyutyunnikov/query-monitor.git .
cp config.dist.php config.php
```

# Using

```sh
php -S localhost:8000 app.php > /tmp/web.log &
```

# Credentials

    User: admin
    Password: pass
