<?php

if (php_sapi_name() != "cli") {
    echo 'not cli';
    die();
}

require_once('../config.php');

if(!defined("STDIN")) {
    define("STDIN", fopen('php://stdin','rb'));
}
echo 'You are about to delete an entry from links collection by idstring.' . PHP_EOL;

$gettinginput = true;

$input = [];

while ($gettinginput) {
    echo 'ID String: ';
    $input['idstring'] = fgets(STDIN);
    echo PHP_EOL;
    $input['idstring'] = filter_var($input['idstring'], FILTER_SANITIZE_STRIPPED);
    $input['idstring'] = trim($input['idstring']);


    $gettinginput = false;

    if (in_array(false, $input)) {
        $input['idstring'] = trim($input['idstring']);
        $gettinginput = true;
    } else {
        echo "Input okay." . PHP_EOL;
    }
}

echo "Are you sure you want to delete the link?  Type 'yes' to continue: ";

$confirm = fread(STDIN, 80); // Read up to 80 characters or a newline
if (trim($confirm) != 'yes') {
    echo "ABORTING!" . PHP_EOL;
    exit;
}

$collection = $DB->selectCollection('links');
$result = $collection->findOneAndDelete(['idstring' => $input['idstring']]);
if ($result != null && $result->idstring == $input['idstring']) {
    echo 'Deleted successfully' . PHP_EOL;
} else {
    echo 'There might have been an issue.' . PHP_EOL;
}
echo "DONE";