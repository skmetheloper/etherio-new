<?php

namespace Ethereal\Framework\Helper;

class LoadModule
{
    private $classDIr = __DIR__ . '/classes';
    private $funcDir  = __DIR__ . '/function';
    protected function __construct($dir, $name, $ext = 'php')
    {
        $this->baseDir = $this->{$dir} ?? false;
        $this->file_path = "{$this->baseDir}/$name.$ext";

        if (!$this->baseDir) return;
        if (is_file($this->file_path)) return require $this->file_path;

        throw new \Exception("{$this->file_path} is not existed to load as Function Module!");
    }

    public static function func($name)
    {
        return new self('funcDir', $name);
    }
}
