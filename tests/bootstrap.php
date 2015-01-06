<?php

$src = realpath(dirname(__FILE__) . '/../src/');

function loader($path)
{
    foreach (scandir($path) as $filename) {
        if ($filename === '.' || $filename === '..') {
            continue;
        }
        $fullPath = $path . '/' . $filename;
        if (is_file($fullPath)) {
            require_once $fullPath;
        } elseif (is_dir($fullPath)) {
            loader($fullPath);
        }
    }
}

loader($src);

$base = realpath(dirname(__FILE__)) . '/ChatworkTestBase.php';
require_once $base;