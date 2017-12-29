<?php
require_once __DIR__.'/../src/Template.php';
use TemplateEngine\Template as Template;

error_reporting(E_ALL);
ini_set('display_errors', 1);


$template = new Template;
$template->add('username', 'Dmitry');
