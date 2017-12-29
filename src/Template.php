<?php

namespace TemplateEngine;

class Template
{
    private $vars = array();

    public function add($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function render($template)
    {
        $path = $template . '.php';
        if (file_exists($path)) {
            $content = file_get_contents($path);

            return $content;
        } else {
            return '404 NOT Found';
        }
    }
}