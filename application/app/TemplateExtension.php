<?php

namespace App;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class TemplateExtension implements ExtensionInterface
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('session', [$this, 'session']);
        $engine->registerFunction('csrf_name', [$this, 'csrf_name']);
        $engine->registerFunction('csrf_token', [$this, 'csrf_token']);
        $engine->registerFunction('old', [$this, 'old']);
        $engine->registerFunction('error', [$this, 'error']);
        $engine->registerFunction('has_error', [$this, 'has_error']);
    }

    public function session()
    {
        return $this->CI->session;
    }

    public function old($key, $default_value = '')
    {
        return $this->session()->old[$key] ?? $default_value;
    }

    public function error($key)
    {
        return $this->session()->errors[$key] ?? false;
    }

    public function has_error($key)
    {
        return isset($this->session()->errors[$key]);
    }

    public function csrf_name()
    {
        return $this->CI->security->get_csrf_token_name();
    }

    public function csrf_token()
    {
        return $this->CI->security->get_csrf_hash();
    }
}