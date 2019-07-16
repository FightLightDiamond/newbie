# Newbie
## Setup
### Docker setup
```angular2html
docker-compose up
make docker-connect
```

### Copy .env.example
```angular2html
 cp .env.example .env
```

### Install package
```angular2html
composer install
```

### Generate key
```angular2html
php artisan key:generate
```
### Update config
```angular2html
php artisan config:clear
```

### Migrate db
```angular2html
php artisan migrate
```

### Run seed
```angular2html
php artisan db:seed
```

## Exercise

```angular2html
php artisan tinker
```