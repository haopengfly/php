<?php

interface Log
{
    function write();
}

class FileLog implements Log
{
    function write()
    {
        echo 'write file_log';
    }
}

class DatabaseLog implements Log
{
    function write()
    {
        echo 'write database_log';
    }
}

class User
{
    protected $log;

    function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function login()
    {
        $this->log->write();
    }
}

class Ioc
{
    protected $binding = [];

    public function bind($abstract,$concrete){
        // 这里为什么要返回一个closure呢？因为bind的时候还不需要创建User对象，所以采用closure等make的时候再创建FileLog;
        $this->binding[$abstract]['concrete'] = function ($ioc) use ($concrete) {
            return $ioc->build($concrete);
        };
    }

    public function make($abstract)
    {
        $concrete = $this->binding[$abstract]['concrete'];
        return $concrete($this);
    }

    // 创建对象
    private function build($concrete)
    {
        $reflector = new \reflectionClass($concrete);
        $constructor = $reflector->getConstructor();

        if(is_null($constructor)){
            return $reflector->newInstance();
        }else{
            $dependencies = $constructor->getParameters();
            $instances = $this->getDependencies($dependencies);
            return $reflector->newInstanceArgs($instances);
        }
    }

    // 获取参数的依赖
    protected function getDependencies($paramters)
    {
        $dependencies = [];

        foreach ($paramters as $paramter){
            $dependencies[] = $this->make($paramter->getClass()->name);
        }
        return $dependencies;
    }
}

$ioc = new Ioc();
$ioc->bind('Log','DatabaseLog');
$ioc->bind('user','User');
$user = $ioc->make('user');
$user->login();
