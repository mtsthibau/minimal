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
    return $file;
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

function getFile($fileName)
{

    if (!$fileName) {
        return "missing file name";
    }

    $file = basename($fileName);
    $file = '/var/www/hermes-api/' . $file;

    if (!file_exists($file)) { // file does not exist
        return 'file not found';
    }

    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$fileName");
    //Define Content Type
    //File can be created as text but need to be tested after converted
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Transfer-Encoding: binary");

    // read the file from disk
    readfile($file);

    return $file;
}
