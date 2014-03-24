# Kurl Shopify web application

Website http://shopify.kurl.co.uk

http://docs.shopify.com/themes/theme-templates/customers

## Setup instructions

### Update file permissions:

#### OSX
```
$ sudo chmod +a "_www allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
$ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
```

#### RHEL
```
$ sudo setfacl -R -m u:apache:rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:apache:rwx -m u:`whoami`:rwx app/cache app/logs
```

### Run composer.phar install

## Setting up access for multiple users

When running a development or production environment it is sometimes necessary to allow many users access to update or
maintain the project. One solution is to add these users to a group, below is a rough idea of how to do so:

### Setup a new user and add to the group

```
$ groupadd <group name>
$ useradd <new username>
$ passwd <new username>
$ usermod -a -G <group name> <new username>
```

### Allow shared access to the git folder

```
$ cd /var/www/<directory>
$ git init --shared=group
```

### Setup permissions

```
$ cd /var/www/
$ chown -R :<group name> <directory>
$ chmod -R g+swX <directory>
$ cd /var/www/<directory>
$ rm -rf app/cache/*
$ rm -rf app/logs/*
$ setfacl -R -m u:<http username>:rwX -m g:<group name>:rwX app/cache app/logs
$ setfacl -dR -m u:<http username>:rwx -m g:<group name>:rwx app/cache app/logs
```

### Check it all worked

```
$ php app/console cache:clear --env=prod
```

rm -rf app/cache/*
rm -rf app/logs/*

APACHEUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data' | grep -v root | head -1 | cut -d\  -f1`
sudo chmod +a "$APACHEUSER allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs

chmod -R g+swX ./
chown -R :$APACHEUSER ./