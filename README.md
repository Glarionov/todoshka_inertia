Простой todo-list, основан на стандартном пакете laravel breeze с базой данных на postgreSQL.

Для запуска склонируйте проект
- git clone https://github.com/Glarionov/todoshka_inertia.git

Перейдите в папку с проектом
- cd todoshka_inertia

Далее запускать команды из этой директории.

Запустите команду

- cp .env.example .env

Выделенную область запускать целиком, как одну команду
```
sudo docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php81-composer:latest \
composer install --ignore-platform-reqs
```

Далее по очереди запустите следующие команды
- chmod -R 777 .
- vendor/bin/sail up -d
- vendor/bin/sail php artisan migrate --seed
- vendor/bin/sail npm i
- vendor/bin/sail npm run dev

Откройте

http://localhost/

в своём браузере.

Для входа можете использовать адрес "test@example.com" или любой другой из таблицы "users", пароль - password

