<?php

if (php_sapi_name() != "cli") {
    echo 'not cli';
    die();
}

require_once('../config.php');

if(!defined("STDIN")) {
    define("STDIN", fopen('php://stdin','rb'));
}
echo 'You are about to add a new entry to links collection.' . PHP_EOL;

$gettinginput = true;

$input = [];

while ($gettinginput) {
    echo 'ID String: ';
    $input['idstring'] = fgets(STDIN);
    echo PHP_EOL;
    $input['idstring'] = filter_var($input['idstring'], FILTER_SANITIZE_STRIPPED);

    echo 'Name: ';
    $input['name'] = fgets(STDIN);
    echo PHP_EOL;
    $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRIPPED);

    echo 'Description: ';
    $input['description'] = fgets(STDIN);
    echo PHP_EOL;
    $input['description'] = filter_var($input['description'], FILTER_SANITIZE_STRIPPED);

    echo 'Icon Type (bootstrap or custom, etc): ';
    $input['itype'] = fgets(STDIN);
    echo PHP_EOL;
    $input['itype'] = filter_var($input['itype'], FILTER_SANITIZE_STRIPPED);

    echo 'Icon Name: ';
    $input['iname'] = fgets(STDIN);
    echo PHP_EOL;
    $input['iname'] = filter_var($input['iname'], FILTER_SANITIZE_STRIPPED);

    echo 'URL (make sure to include https://): ';
    $input['url'] = fgets(STDIN);
    echo PHP_EOL;
    $input['url'] = filter_var($input['url'], FILTER_SANITIZE_URL);

    echo 'Source (What link to display, eg google.co.uk): ';
    $input['source'] = fgets(STDIN);
    echo PHP_EOL;
    $input['source'] = filter_var($input['source'], FILTER_SANITIZE_STRIPPED);

    echo 'Tags (comma,seperated,words): ';
    $input['tags'] = fgets(STDIN);
    echo PHP_EOL;
    $input['tags'] = filter_var($input['tags'], FILTER_SANITIZE_STRIPPED);

    $gettinginput = false;

    foreach ($input as $key => $value) {
        $input[$key] = trim($value);
    }

    if (in_array(false, $input)) {
        $gettinginput = true;
    } else {
        echo "Input okay." . PHP_EOL;
    }
}

$data = input_to_data($input);
// print_r($data);
echo PHP_EOL;

echo "Are you sure you want to add a new link?  Type 'yes' to continue: ";

$confirm = fread(STDIN, 80); // Read up to 80 characters or a newline
if (trim($confirm) != 'yes') {
    echo "ABORTING!" . PHP_EOL;
    exit;
}

$collection = $DB->selectCollection('links');

foreach ($data as $id => $item) {
    $collection->insertOne($item);
}

echo "DONE";