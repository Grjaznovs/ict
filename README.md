Docker Desktop 4.34.1

### For first time only !
- `git clone https://github.com/Grjaznovs/ict.git`
- `cd ict`
- `docker compose up -d --build`
- `composer update`
- `docker compose exec phpmyadmin chmod 777 /sessions`
- `docker compose exec php bash`
- `ls -la`
- `chown -R (YOUR USER ID):(YOUR USER ID) /var/www/storage /var/www/bootstrap/cache`
- `chmod -R 777 /var/www/storage /var/www/bootstrap/cache`
- `composer setup`
- `exit`
- `docker compose up -d`
- `npm run dev`

### Laravel App
- URL: http://localhost

### phpMyAdmin
- URL: http://localhost:8080
- Server: `db`
- Username: `rootUser`
- Password: `qwerty`
- Database: `ict`
