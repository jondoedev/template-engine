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

    /**
     * @param $file
     *
     * @return string
     * $file - name of required template file without extension,
     * for example $template_object->render('example');
     *
     * also this method implements a custom syntax using regular expressions
     */
    public function __render($file)
    {
        $path = __DIR__ . '/../templates/' . $file . '.php';
        if (file_exists($path)) {
            $content = file_get_contents($path);

            $content = preg_replace_callback("/{% partial '(.*)' %}/", function ($matches) {
                return file_get_contents(__DIR__ . '/../templates/' . $matches[1] . '.php');
            }, $content);

            $content = preg_replace_callback("/{% partial '(.*)', (\[.*\]) %}/", function ($matches) {
                return "<?php extract(" . $matches[2] . "); ?>\n" . file_get_contents(__DIR__ . '/../templates/' . $matches[1] . '.php');
            }, $content);

            $content = preg_replace('/{% (.*?) %}/', '<?= \$$1 ?>', $content);
            //custom syntax for foreach cycle
            $content = preg_replace('/\{% foreach (.*) %}/', '<?php foreach ($1) : ?>', $content);
            $content = preg_replace('/\{% endforeach %}/', '<?php foreach; ?>', $content);

            //custom syntax for if condition
            $content = preg_replace('/\{% if (.*) %}/', '<?php if ($1) : ?>', $content);
            $content = preg_replace('/\{% else %}/', '<?php else : ?>', $content);
            $content = preg_replace('/\{% endif %}/', '<?php endif; ?>', $content);

            //custom syntax for php tags
            //TODO:: Similar syntax for all constructions!!!
            $content = preg_replace('/\{ (.*) }/', '<?php $this->$1 ?>', $content);

            //to see the compiled php code
            $compiled_path = __DIR__ . '/../compiled_templates/' . $file . '.php';
            file_put_contents($compiled_path, $content);

            ob_start();
            extract($this->vars);
            require_once __DIR__ . "/../templates/" .  $this->layout .".php";
            $layout = ob_get_clean();

            eval(' ?>' . $layout . $content . '<?php ');

            return ob_get_clean();

        } else {
            exit('<h1>Template Error</h1>');
        }
    }

    public function render($file)
    {
        $path = __DIR__ . '/../templates/' . $file . '.php';
        $content = file_get_contents($path);
        $content = preg_replace('/{% (.*?) %}/', '<?= \$$1 ?>', $content);
        ob_start();
        extract($this->vars);
        require_once __DIR__ . "/../templates/" . $this->layout . ".php";
        $layout = ob_get_clean();
        eval(' ?>' . $layout . $content . '<?php ');
        return ob_get_clean();
    }

    public function partial($file, array $vars = [])
    {
        if (!empty($vars)){
            $this->vars = $vars;
        }
        $path = __DIR__ . '/../templates/' . $file . '.php';
        $content = file_get_contents($path);
        $content = preg_replace('/{% (.*?) %}/', '<?= \$$1 ?>', $content);
        ob_start();
        extract($this->vars);
        eval(' ?>' . $content . '<?php ');
        return ob_get_clean();
    }

}