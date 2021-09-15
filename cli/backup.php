<?php

if (php_sapi_name() != "cli") {
    echo 'not cli';
    die();
}

require_once('../config.php');
/**
 * This script makes a backup of the MongoDB 'links' collection, timestamped.
 *
 */
$json = json_encode(fetch_prepared_data([], 'mongo', 'none'));
$filename = $CFG->dirroot . $CFG->dirsept . 'backup' . $CFG->dirsept . 'data-' . time() . '.json';

file_put_contents($filename, $json);

echo 'Backed up.';