<?php

$system_dir = 'system';
$data_dir   = 'data';
$site_dir   = 'site';
$extensions_dir = 'extensions';
$public_dir = 'public';

define('DS', DIRECTORY_SEPARATOR);
define('DOCROOT', __DIR__.DS);

require_once( $system_dir . '/bootstrap.php' );