<?php

if (php_sapi_name() != "cli") {
    echo 'not cli';
    die();
}

require_once('../config.php');
require_once('backup.php');

/**
 * After backing up the collection, it drops the links collection.
 */

$collection = $DB->selectCollection('links');
$collection->drop();
