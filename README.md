<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>



## About Data import

This project is a sample about jobs & queues to import a huge amount of products using CSV files.

Queues can be configured in environment file. Possible queue drivers are DB and Redis (used DB by default).

##  Steps to get project running 🛠

1. Create `.env` file: copy or rename `.env.example` located in project root folder. Run `php artisan key:generate` 
to generate a new application key.

2. Setup database: First of all, create your database and set corresponding connection parameters in the `.env` file.

3. migrate & seed: to generate migrations run command `php artisan migrate`. Then run seeds with `php artisan db:seed`

4. start queue workers:

    <ins>If application runs under Windows system:</ins>
    
    Run `START /b php artisan queue:work --timeout=0` to start processing queue in background.
    
    <ins>If application runs under Unix system:</ins>
    
    Run ``nohup php artisan queue:work --timeout=0 &`` to start processing queue in background.

## Running project 🚀

You can simply generate a random products file with whe generation button of the index card header.

Before uploading a CSV make sure queue is running. If not Job will be generated but bot imported.
([Laravel queues](https://laravel.com/docs/7.x/queues)).



## Vulnerabilities & contributions

If you discover a security vulnerability, please send an e-mail to Sergio Martín via [sergyzen@gmail.com](mailto:sergyzen@gmail.com). 
All security vulnerabilities will be promptly addressed.

## License

This software is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
