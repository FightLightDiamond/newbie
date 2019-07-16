#Newbie
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

### 
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

### Seed db
```angular2html
php artisan make:seed UsersTableSeeder
```

### Content UsersTableSeeder
```angular2html
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 100)->create();
    }
}
```

### Run seed
```angular2html
php artisan db:seed
```

## Exercise

```angular2html
php artisan tinker
```