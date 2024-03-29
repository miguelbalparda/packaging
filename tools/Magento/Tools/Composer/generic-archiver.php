<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
require_once __DIR__ . '/Helper/Zipper.php';

use Magento\Tools\Composer\Helper\Zipper;

define(
'SYNOPSIS',
<<<SYNOPSIS
php -f generic-archiver.php --
    --dir="Source directory"
    --output="Generation directory"
    --packages="Package list"
SYNOPSIS
);
$options = getopt('', [
    'dir:', 'output::', 'packages::'
]);
$requiredArgs = ['dir'];
foreach ($requiredArgs as $arg) {
    if (empty($options[$arg])) {
        echo SYNOPSIS;
        exit(1);
    }
}

$dir = realpath($options['dir']);
$output = isset($options['output']) ? $options['output'] : __DIR__ . '/_packages';
$packageList = $options['packages'];

/**
 * Composer Archiver Tool
 *
 * This tool creates archive (zip) package from source directory
 */
try {
    echo sprintf("Your package(s) source directory: %s" . PHP_EOL, $dir);
    echo sprintf("Your archive(s) output directory: %s." . PHP_EOL, $output);
    if (!empty($packageList)) {
        echo sprintf("Creating archive for the following packages: %s. " . PHP_EOL, $packageList);
    }

    if (!file_exists($output)) {
        if (!mkdir($output, 0777, true)) {
            echo sprintf("ERROR: Creating Directory %s failed." . PHP_EOL, $output);
        }
    }
    archive($dir, $output, $packageList);
} catch (\Exception $e) {
    exit($e->getMessage());
}
exit(0);

/**
 * @param string $source
 * @param string $output
 * @param string $packageList
 * @return int
 * @throws Exception
 */
function archive($source, $output, $packageList)
{
    $dirs = [];
    $file = $source . '/composer.json';
    if (file_exists($file)) {
        $dirs[] = $source;
    } else {
        $dirs = glob(rtrim($source, '/') . '/*', GLOB_ONLYDIR);
    }

    $noOfZips = 0;
    foreach ($dirs as $dir) {
        $file = $dir . '/composer.json';
        if (file_exists($file)) {
            $json = json_decode(file_get_contents($file));

            $version = $json->version;
            $packageName = str_replace('/', '_', $json->name);

            if (empty($packageList) || strpos($packageList, $packageName) !== false) {
                $fileName = $packageName . "-{$version}" . '.zip';
                $dir = str_replace('\\', '/', realpath($dir));

                $noOfZips = Zipper::zip($dir, $output . '/' . $fileName, []);
                echo sprintf("SUCCESS: Created zip archive for %-40s [%9s]" . PHP_EOL, $fileName, $version);
            }
        }
    }
    return $noOfZips;
}
