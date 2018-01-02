<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__.'/../vendor/autoload.php';


$tpl = new \TemplateEngine\Template;
$tpl->setHelper('hello', function (){return 'Hello, ';});
$tpl->appendMultuple([
                    'name' => 'Dmitry',
                    'last_name' => 'Kalenyuk',
                    'age' => 21,
                    'position' => 'PHP Trainee',
                    'company' => 'CodeIT'
                    ]);

$tpl->render('main');

