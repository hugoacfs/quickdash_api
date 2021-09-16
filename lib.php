<?php

function loaddata_json() {
    global $CFG;
    if ($CFG->configok != true) {
        return false;
    }
    $filepath = $CFG->dirroot . $CFG->dirsept . 'data.json';
    $data = json_decode(file_get_contents($filepath), true);
    return $data;
}

function loaddata_mongo() {
    global $DB;
    $data = [];
    $col = $DB->selectCollection('links');
    $cursor = $col->find();
    foreach ($cursor as $item) {
        $data[$item['idstring']] = $item;
    }
    return ['links' => $data];
}

/**
 * @deprecated
 */
function loadsvghtml(string $name, string $type) : string {
    $svg = '';
    switch ($type) {
        case 'bootstrap':
            $svg = '<i class="bi-' . $name . '"></i>';
            break;
        default:
            $svg = loadsvgraw($name, $type);
            break;
    }
    return $svg;
}

function loadsvgraw(string $name = 'bootstrap', string $type = 'bootstrap') : string {
    global $CFG;
    $path = $CFG->dirroot .
            $CFG->dirsept .
            'api' .
            $CFG->dirsept .
            'icons' .
            $CFG->dirsept .
            $type .
            $CFG->dirsept .
            $name . '.svg';
    if (!file_exists($path)) {
        // If file does not exist, load something default.
        return loadsvgraw('link-45deg');
    }
    // We must remove any set sizes, so we can control this in CSS.
    $svg = file_get_contents($path);
    $xml = simplexml_load_string($svg);
    $width = 'width';
    $height = 'height';
    $class = 'class';
    $fill = 'fill';
    unset($xml->attributes()->$width);
    unset($xml->attributes()->$height);
    unset($xml->attributes()->$fill);
    $xml->attributes()->$class = "svg-$type-$name dash-svg";
    return $xml->asXML();
}

function fetch_prepared_data(array $tags = [], string $referrer = '', string $dbmode = '', string $svgmode = 'raw') {
    global $CFG;
    if ($dbmode == '') {
        $dbmode = $CFG->dbmode;
    }
    $data = [];
    error_log("QUICKDASH API: $dbmode MODE ON");
    switch ($dbmode) {
        case 'mongo':
            $data = loaddata_mongo();
            break;
        case 'json':
            $data = loaddata_json();
            break;
        default:
            $data = loaddata_json();
            break;
    }
    $links = [];
    $positionlinks = [];
    foreach ($data['links'] as $key => $item) {
        if (!is_array($item)) {
            $item = (array) $item;
        }
        $item['idstring'] = $key;
        if (array_key_exists('hide', $item) && $item['hide'] == 'true') {
            continue;
        }
        if (!empty($tags)) {
            $intersect = array_intersect($tags, $item['tags']) ?? [];
            $counttags = count($intersect);
            if ($counttags < 1) {
                continue;
            }
        }
        if (isset($item['origin']) && $item['origin'] != $referrer) {
            $item['target'] = 'new';
        }
        if ($svgmode == 'raw') {
            $item['svg'] = loadsvgraw($item['icon']['name'], $item['icon']['type']);
        }
        if (array_key_exists('position', $item)) {
            $positionlinks[$item['position']] = $item;
        } else {
            $links[$key] = $item;
        }
    }
    // Joining both arrays
    $links = array_merge($positionlinks, $links);
    return $links;
}

function input_to_data (array $input) {
    // This is the outter array, to mimic the rest of the data.
    $links = [];
    $idstring = $input['idstring'];
    $tags = explode(',', $input['tags']) ?? [];
    $links[$idstring] = [
        'idstring' => $input['idstring'],
        'name' => $input['name'],
        'description' => $input['description'],
        'icon' => [
            'name' => $input['iname'],
            'type' => $input['itype']
        ],
        'url' => $input['url'],
        'source' => $input['source'],
        'tags' => $tags
    ];
    return $links;
}