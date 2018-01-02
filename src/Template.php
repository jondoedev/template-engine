<?php

namespace TemplateEngine;

class Template
{
    public $vars = [];
    public $helpers = [];

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
        foreach ($array as $key => $value)
        {
            $this->vars[$key] = $value;
        }
    }

    /**
     * @param $name
     * @param $handler
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

//    public function partial($file, array $visibleVars)
//    {
//        if(empty($visibleVars)){
//            $visibleVars = $this->vars;
//        }
//    }
//

    /**
     * @param $file
     * $file - name of required template file without extension,
     * for example $template_object->render('example');
     *
     * also this method implements a custom syntax using regular expressions
     */
    public function render($file)
    {
        $path = __DIR__ . '/../templates/' . $file . '.php';
        if (file_exists($path)) {
            $content = file_get_contents($path);

/*            $content = preg_replace('/\{% partial \'(.*)\' \%}/', '<?php include __DIR__.\'/../templates/$1.php\' ?>', $content);*/

	        $compiled_path = __DIR__.'/../compiled_templates/' . $file . '.php';
	        file_put_contents($compiled_path, $content);

            eval(' ?>' . $content . '<?php ');
//			require $compiled_path;
            foreach ($this->vars as $key => $value) {
                $content = preg_replace('/\{' . $key . '\}/', $value, $content);
            }

            //custom synax for foreach cycle
            $content = preg_replace('/\{ foreach (.*) \}/', '<?php foreach ($1) : ?>',$content);
            $content = preg_replace('/\{ endforeach \}/', '<?php foreach; ?>',$content);

            //custom syntax for if condition
            $content = preg_replace('/\<\!\-\- if (.*) \-\-\>/', '<?php if ($1) : ?>',$content);
            $content = preg_replace('/\<\!\-\- else \-\-\>/', '<?php else : ?>',$content);
            $content = preg_replace('/\<\!\-\- endif \-\-\>/', '<?php endif; ?>',$content);

            $content = preg_replace('/\{% partial \'(.*)\' \%}/', '<?php include __DIR__.\'/../templates/$1.php\' ?>', $content);

        } else {
            exit('<h1>Template Error</h1>');
        }
    }
}