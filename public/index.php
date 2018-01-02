<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';


$tpl = new \TemplateEngine\Template;
$tpl->setHelper('hello', function () {
    return 'Hello, ';
});
$tpl->setHelper('currentDate', function () {
    echo date('m:d:Y');
});
$tpl->append([
    'name' => 'Dmitry',
    'last_name' => 'Kalenyuk',
    'age' => 21,
    'position' => 'PHP Trainee',
    'company' => 'CodeIT'
]);
$tpl->append(['pageTitle' => 'CodeIT | Template Engine']);
$tpl->setHelper('listParse', function ($data) {
    foreach ($data as $key => $value) {
        echo '<li><b>' . $key . '</b> : ' . $value . '</li>';
    }
});



$tpl->render('main');

