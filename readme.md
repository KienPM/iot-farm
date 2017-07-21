# Install PHP server

```
composer install
```

```
php artisan migrate
```

```
sudo chmod 777 -R bootstrap/cache storage/
```

# Install package for node server
```
npm install
```

# Forever
## Install

```
npm install forever -g
```

## Chạy server nodejs

`forever server.js` hoặc `node server.js`
## Stop all
`forever stopall`

## Help
`forever -h`


**Chú ý:**
- `npm install forever -g` chỉ cần install 1 lần lần sau không cần chạy lệnh này nữa
- các lệnh còn lại phải chạy khi pull code mới về.
