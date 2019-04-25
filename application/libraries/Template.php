<?php

use App\TemplateExtension;

class Template
{
    public function __construct()
    {
        $this->engine = new League\Plates\Engine(__DIR__ . '/../templates', 'php');
        $this->engine->loadExtension(new TemplateExtension());
    }

    public function __call($method, $args)
    {
        $result = $this->engine->{$method}(...$args);

        if ($method == "render") {
            echo $result;
        }
        
        return $result;
    }
}