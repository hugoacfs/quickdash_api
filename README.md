# quickdash_api
The API service responsible for serving svg images and links data to [this client](https://github.com/hugoacfs/quickdash_client).

This project requires PHP version 7.4.

## If using MongoDB:
*(feature preview)*

To install packages: `$ composer install` - **only needed if you plan on using MongoDB**.

## Configuration and Setup:
1. Copy `config-dist.php` to `config.php`.
2. Copy `data-dist.json` to `data.json`.


## Files

### -> data.json
- The file `data.json` is used as an initial data repository that mongoDB uses to populate itself, it can be used as the database if wanted, by changing `dbmode` in `config.php`.
### -> config.php
- This file holds the configuration variable used throughout the code.
- ->`dbmode` defines whether to use data.json or mongodb.
- ->`dbname` is only applicable if using mongodb, refers to the name of the database used.
- ->`debug` is used to display error messages, if set to `true`.
- The rest of the configuration file is used to load up mongodb dependencies.


