<?php
// Config global.
$CFG = new stdClass;

// Directory vars.
$CFG->dirroot = __DIR__;
$CFG->dirsept = DIRECTORY_SEPARATOR;

// Add configuration items here.

$CFG->debug = false;
if ($CFG->debug) {
    ini_set('error_logs', 1);
    ini_set('display_error', 1);
    error_log("[QUICKDASH] DEBUG ON!");
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