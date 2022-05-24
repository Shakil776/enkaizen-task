<p align="center"><h2>Image Uploader Application using Laravel and VueJS</h2></p>

## Install procedure

    => Go to the project folder using cmd or terminal then use the command
    * Clone the project
    1. composer install / composer update
    2. copy .env.example .env
    3. php artisan key:generate
    4. php artisan storage:link
    5. Now configure your database username, password, host etc in your .env file
    6. php artisan migrate
    7. JWT Secret key: php artisan jwt:secret
    8. php artisan optimize
    9. npm install
    10. npm run dev/watch
    11. php artisan serve
    12. php artisan queue:work
    13. php artisan websockets:serve

## Put all credentials in .env file

    1. BROADCAST_DRIVER=pusher
    2. QUEUE_CONNECTION=database
    3. Pusher credentials
            PUSHER_APP_ID=12345
            PUSHER_APP_KEY=12345
            PUSHER_APP_SECRET=12345
            PUSHER_APP_CLUSTER=mt1
    4. JWT_SECRET=generate your jwt secret key

Thank You
