<?php

namespace TemplateEngine;

class Template
{
    private $vars = [];
    public $helpers = [];
    public static $config;
    public $layout;

    public function __construct($file)
    {
        $path = __DIR__ . '/../templates/' . $file . '.php';
        if (file_exists($path)) {
            $this->layout = $file;
        }else{
            echo '<h1>Render Error</h1>';
        }
    }

    /**
     * @param $array
     *
     * add an array of variables to $vars array
     * example:
     * $template_object->append([
     *                                          'var1' => value1,
     *                                          'var2' => 'value2'
     *                                          ]);
     */

    public function append($array)
    {
        foreach ($array as $key => $value) {
            $this->vars[$key] = $value;
        }
    }

    /**
     * @param $name
     * @param $handler
     *
     * @return mixed
     * add a helper function
     *
     * usage example:
     * $template_object->setHelper('CurrentDate' => function(){return date(m:d:Y)})
     *
     */
    public function setHelper($name, $handler)
    {
        $this->helpers[$name] = $handler;

        return $handler;
    }

    /**
     * @param $helper
     * @param $arguments
     *
     * @return mixed
     * a __call method that allows us to call created helpers from template
     * usage example:
     * <?= self->HelperName() ?>
     */
    public function __call($helper, $arguments)
    {
        return call_user_func_array($this->helpers[$helper], $arguments);
    }

    /**
     * @param $var
     * method allows us to delete single variable from $vars array
     * usage example:
     * $template_object->unsetVar('name');
     */
    public function unsetVar($var)
    {
        unset($this->vars[$var]);
    }

    /**
     * method allows us to delete all existing variables from $vars array
     * usage example:
     * $template_object->ClearAll();
     */
    public function ClearAll()
    {
        unset($this->vars);
    }

    public  function render($file = null)
    {
        ob_start();
        extract($this->vars);
        if ($file == null){
            require_once __DIR__ . "/../templates/" . $this->layout . ".php";
        }else{
            require_once __DIR__ . "/../templates/" . $this->layout . ".php";
            require_once __DIR__ . "/../templates/$file.php";
        }
        $output = ob_get_clean();
        return $output;
    }

    /**
     * @param $file
     *
     * @return string
     * $file - name of required template file without extension,
     * for example $template_object->render('example');
     *
     * also this method implements a custom syntax using regular expressions
     */


    public function partial($file, array $vars = null)
    {
        if (!empty($vars) and isset($vars) ){
            foreach ($vars as $key => $value){
                $this->vars[$key] = $value;
            }
        }else{
            $vars = $this->vars;
        }

        $path = __DIR__ . '/../templates/' . $file . '.php';
        file_get_contents($path);
        ob_start();
        extract($vars);
        var_dump($vars);
        die();
        require_once __DIR__ . "/../templates/$file.php";
        $output = ob_get_clean();
        echo $output;
    }

}