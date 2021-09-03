<?php

function loaddata() {
    global $CFG;
    if ($CFG->configok != true) {
        return false;
    }
    $filepath = $CFG->dirroot . $CFG->dirsept . 'data.json';
    $data = json_decode(file_get_contents($filepath), true);
    return $data;
}

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

function loadsvgraw(string $name, string $type) : string {
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

function fetch_prepared_data() {
    $data = loaddata();
    $links = [];
    foreach ($data['links'] as $key => $item) {
        $item['svg'] = loadsvgraw($item['icon']['name'], $item['icon']['type']);
        $links[] = $item;
    }
    return $links;
}