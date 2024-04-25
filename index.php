<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $files = getFilesFromDir();
    echo json_encode(array('message' => $files));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileName = $_GET['file'];

    $file = getFile($fileName);
    echo json_encode(array('message' => $files));
}


function getFilesFromDir()
{
    $path = '/var/www/hermes-api'; //should have parmission if not this will return false

    $paths = [];
    if (is_dir($path)) {
        $scanpathvalues = scandir($path);
        if (is_array($scanpathvalues) || is_object($scanpathvalues)) {
            foreach ($scanpathvalues as $name) {
                if ($name !== '.' && $name !== '..' && !is_dir($path . '/' . $name)) {
                    $paths[] = $name;
                }
            }
        }
    }
    return $paths;
}

function getFile($fileName){
    return 'file';
}

