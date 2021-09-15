# quickdash_api

To install packages: `$ composer install` - **only needed if you plan on using MongoDB**.

Copy `config-dist.php` to `config.php`.

Copy `data-dist.json` to `data.json`.

The file `data.json` is used as an initial data repository that mongoDB uses to populate itself, it can be used as the database if wanted, by changing `dbmode` in `config.php`.