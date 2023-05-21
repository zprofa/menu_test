## README

clone project or unzip it:
```
git clone https://github.com/zprofa/menu_test.git
```

Navigate to root folder:
```
cd menu_test
```

Run composer install out of container from project root:
```
composer install
```

Copy .env:
```
cp .env.dev .env
```

Start container:
```
./vendor/bin/sail up -d
```

After images are crated and container started go into container:
```
docker exec -it menu_test-menu_test-1 bash
```

Run migrations into container:
```
php artisan migrate:fresh --seed
```

Navigate in your browser to:
```
http://localhost:8097
```

If some permission problems occur fix them. 

To refresh currency rates run:
```
php artisan app:currencies
```
