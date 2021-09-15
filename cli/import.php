<?php

if (php_sapi_name() != "cli") {
    echo 'not cli';
    die();
}

require_once('../config.php');

/**
 * Using the data.json file, this script generates a MongoDB links collection.
 */

$data = fetch_prepared_data([], 'json', 'none');
$collection = $DB->selectCollection('links');

foreach ($data as $item) {
    $collection->insertOne($item);
}