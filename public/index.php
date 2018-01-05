<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';


$tpl = new \TemplateEngine\Template( 'layout');
$tpl->setHelper('hello', function () {
    echo 'Hello, ';
});
$tpl->setHelper('currentDate', function () {
    echo date('m:d:Y');
});
$tpl->setHelper('listParse', function ($data) {
    foreach ($data as $key => $value) {
        echo '<li><b>' . $key . '</b> : ' . $value . '</li>';
    }
});

// adding multiple variables
$tpl->append([
    'name' => 'Dmitry',
    'last_name' => 'Kalenyuk',
    'age' => 21,
    'position' => 'PHP Trainee',
    'company' => 'CodeIT',
    'projectName' => 'Template Engine',
    'block_3_title' => 'Partial work example',
    'headerAbout' => 'About',
    'headerTour' => 'Tour',
    'headerPricing' => 'Pricing',
    'headerLogin' => 'Login',
    'headerSignUp' => 'Sign Up'
]);

// adding single variable
$tpl->append(['pageTitle' => 'CodeIT | Template Engine']);

$tpl->render('block_3');
$tpl->render('block_1');

