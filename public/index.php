<?php
require_once __DIR__.'/../src/Template.php';
use TemplateEngine\Template as Template;

error_reporting(E_ALL);
ini_set('display_errors', 1);


$tpl = new Template;
$tpl->append('name', 'Dmitry');
$tpl->append('age', '21');
$tpl->append('hobby', 'music');
$tpl->setHelper('hello', function (){echo 'Hello';});
$tpl->setHelper('now', function (){return date('d-m-Y');});

//$tpl->appendMultuple(['cat' => 'meow', 'dog' => 'gav-gav']);




$tpl->render('main');

var_dump($tpl);
