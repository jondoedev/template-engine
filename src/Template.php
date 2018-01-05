<?php

namespace TemplateEngine;

class Template
{
    private $buffer =[];
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



    /**
     * @param $file
     *
     * @return string
     * $file - name of required template file without extension,
     * for example $template_object->render('example');
     *
     * also this method implements a custom syntax using regular expressions
     */


    public function render($filename)
    {
        // fix for vars rewriting
        $this->buffer = $this->vars;
        $content = __DIR__.'/../templates/'.$filename.'.php';
        ob_start();
        extract($this->vars);
        if(file_exists($content))
        {
            include $content;
            $content = ob_get_clean();
        }
        require __DIR__ . '/../templates/'. $this->layout .'.php';
    }

    public function partial($file, array $vars = null)
    {
        if (!empty($vars)){
            foreach ($vars as $key => $value) {
                    $this->vars[$key] = $value;
                extract($vars);
            }
        }else{
            extract($this->buffer);
        }
        $path = __DIR__ . '/../templates/' . $file . '.php';
        file_get_contents($path);
        ob_start();
        include ( __DIR__ . "/../templates/$file.php");



    }

}