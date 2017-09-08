<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();
class_alias('Tester\Assert', 'Assert');
date_default_timezone_set('Europe/Prague');

define('TEMP_DIR', __DIR__ . '/tmp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid()));
Tester\Helpers::purge(TEMP_DIR);

$_SERVER = array_intersect_key($_SERVER, array_flip(array('PHP_SELF', 'SCRIPT_NAME', 'SERVER_ADDR', 'SERVER_SOFTWARE', 'HTTP_HOST', 'DOCUMENT_ROOT', 'OS', 'argc', 'argv')));
$_SERVER['REQUEST_TIME'] = 1234567890;
$_ENV = $_GET = $_POST = array();
