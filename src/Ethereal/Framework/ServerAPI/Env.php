<?php
namespace Ethereal\Framework\ServerAPI;

class Env
{
    public $config = [];
    public $baseDir = 'config';

    public function __construct()
    {
        $this->baseDir = "$_SERVER[ROOT_DIR]/{$this->baseDir}";
        $this->install_env();
    }

    public function install_env()
    {
        if (!function_exists('env'))
            return \Ethereal\Framework\Helper\LoadModule::func('env');
    }

    public function get_config(string $name)
    {
        $this->loaded[$name] = "{$this->baseDir}/$name.php";
        $this->config[$name] = require $this->loaded[$name];
        foreach ($this->config[$name] as $key => $value) {
            if (!empty($value)) $_ENV[$key] = $value;
        }
    }
}
