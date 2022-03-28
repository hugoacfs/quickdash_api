# quickdash_api
The API service responsible for serving svg images and links data to [this client](https://github.com/hugoacfs/quickdash_client).

This project requires PHP version 7.4.


## Configuration and Setup:
1. Copy `config-dist.php` to `config.php`.
2. Copy `data-dist.json` to `data.json`.

## -> config.php
The config file is currently only used for debug reasons, it still needs to be created for the project to work.

- This file holds the configuration variable used throughout the code.
- ->`debug` is used to display error messages, if set to `true`.
- The rest of the configuration file is used to load up mongodb dependencies.

