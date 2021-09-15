<?php
// Config global.
$CFG = new stdClass;

// Directory vars.
$CFG->dirroot = __DIR__;
$CFG->dirsept = DIRECTORY_SEPARATOR;

// Add configuration items here.
$CFG->dbmode = 'mongo|json';
$CFG->dbname = 'dash';

$CFG->debug = false;
if ($CFG->debug) {
    ini_set('error_logs', 1);
    ini_set('display_error', 1);
    error_log("[QUICKDASH] DEBUG ON!");
}

// Loading external libs.
$CFG->composerok = false;
$CFG->vendordir = $CFG->dirroot .
                $CFG->dirsept .
                'vendor' .
                $CFG->dirsept .
                'autoload.php';
if (require_once($CFG->vendordir)) {
    $CFG->composerok = true;
}

// Loading lib.
$CFG->libok = false;
$CFG->libdir = $CFG->dirroot .
                $CFG->dirsept .
                'lib.php';
if (require_once($CFG->libdir)) {
    $CFG->libok = true;
}

// This shows config is okay.
$CFG->configok = true;

if ($CFG->dbmode == 'mongo') {
    $MONGO = new MongoDB\Client();
    $DB = $MONGO->selectDatabase($CFG->dbname);
}