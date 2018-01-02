<?php

namespace TemplateEngine;

class Template
{
    public $vars = [];
    public $helpers = [];

    /**
     * @param $key
     * @param $value
     * add a single variable to $vars array
     */
    public function append($key, $value)
    {
        $this->vars[$key] = $value;
    }

    /**
     * @param $array
     *
     * add an array of variables to $vars array
     */
    public function appendMultuple($array)
    {
        foreach ($array as $key => $value)
        {
            $this->vars[$key] = $value;
        }
    }

    public function setHelper($name, $handler)
    {
        $this->helpers[$name] = $handler;
        return $handler;
    }


    public function __call($helper, $arguments)
    {
        return call_user_func_array($this->helpers[$helper], $arguments);
    }


    public function unsetVar($var)
    {
        unset($this->vars[$var]);
    }

    public function ClearAll()
    {
        unset($this->vars);
    }

    public function partial($file, array $visibleVars)
    {
        if(empty($visibleVars)){
            $visibleVars = $this->vars;
        }
    }

    public function render($file)
    {
        $path = __DIR__ . '/../templates/' . $file . '.php';
        if (file_exists($path)) {
            ob_start();
            $content = file_get_contents($path);
            foreach ($this->vars as $key => $value) {
                $content = preg_replace('/\{' . $key . '\}/', $value, $content);
            }
            eval(' ?>' . $content . '<?php ');
        } else {
            exit('<h1>Template Error</h1>');
        }
    }
}