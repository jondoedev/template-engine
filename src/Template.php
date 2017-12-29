<?php

namespace TemplateEngine;

class Template
{
    private $vars = array();

    public function add($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function render($file)
    {
        $path = __DIR__.'/../templates/' . $file . '.php';
        if (file_exists($path)){
            $content = file_get_contents($path);
            eval(' ?>' . $content . '<?php ');
        }else{
            exit('<h1>Template Error</h1>');
        }
    }
}