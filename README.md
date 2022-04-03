# Ukrainian Web Scrapper by Scrappy Devs

- [Rafel Diaz](https://www.linkedin.com/in/rafael-diaz-26368053/)
- [Cristian Fernandez](https://www.linkedin.com/in/cristian-fernandez-dev/)
- [Jeffrey Chee](https://www.linkedin.com/in/jeffrey-chee)
- [Nikolai Quintos](https://www.linkedin.com/in/nikolaiq/)
- [Ricardo Di Zio](https://www.linkedin.com/in/ricardo-di-zio-ab863ab9/)

## About the Ukrainian Web Scrapper 

Web Scraper that focuses on Ukrainian Data. Fixing open communications by providing data to others. Ukrainians and general population that are interested in more information can benefit from this application.

## Project Repo

Repository can be cloned by following the issuing the code below:
`git clone git@github.com:Fall-In-2022/Scrapper.git`

## Running Locally w/ LaraDock

LaraDock guide located here - [https://laradock.io/](https://laradock.io/).

Windows Requirements:
- [Install Hyper-V on Windows 10](https://docs.microsoft.com/en-us/virtualization/hyper-v-on-windows/quick-start/enable-hyper-v)
- [Install WSL](https://docs.microsoft.com/en-us/windows/wsl/install)

How to run this repo locally:

1. Clone both Ukrainian Web Scrapper and LaraDock into the same folder.
2. Open laradock repo with your code editor and:
   - Open `docker-compose.yml`, update to `   - "${NGINX_HOST_HTTP_PORT}:8084"`
   - Open `../nginx/sites/default.conf` delete every code and paste the code from `laravel.conf.example` file.
   - In `default.conf` update all 80 port to 8084, make sure `root /var/www/public;` is set, and `server_name localhost;`.
   - Additionaly, set the location to point to the right file `try_files $uri /public/index.php$is_args$args;`
   - Create new `.env` file in the root directory that's copied from `.env.example`.
   - In the environment file, point `APP_CODE_PATH_HOST=../Scrapper/`, `APP_CODE_PATH_CONTAINER=/var/www/public`, for Windows machine, `COMPOSE_PATH_SEPARATOR=;`, and lastly `PHP_VERSION=8.0`.
3. Open Scrapper repo, and add a `.env` file as well with content copied from `.env.example` file.
4. Make sure LaraDock is up and running.
5. Open console/terminal, and cd to the laradock folder and issue: `docker-compose up -d nginx php-fpm mysql`.
6. Open Windows PowerShell and execute this command: `docker ps`, take a note of your laradock_workspace CONTAINER_ID.
7. In the PowerShell, `docker exec -it {container_id} bash`, `cd public`, and issue `composer install`.
8. Open this URL in the browser and it should be working: [http://localhost:8084/public/](http://localhost:8084/public/).

Set up the database locally:

1. In the Scrapper repo, open the `.env` file
2. Set the following: `DB_HOST=mysql`, `DB_DATABASE=ukraine_web_scrapper`, and finally `DB_PASSWORD=root`.
3. Go into the workspace container and issue the following commands:
   - `cd public`
   - `php artisan config:clear`
   - `php artisan migrate:install`
4. To see the database connect to the docker volume via a program like MySQL Workbench.