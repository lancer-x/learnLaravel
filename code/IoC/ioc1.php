<?php
//一个粗糙的容器
//容器内部维护了一个instance实例数组，通过bind方法将需要的对象绑定到instances上
class container{
    private $instances = [];
    private $binds = [];
    //绑定到容器，可以理解为注册
    public function bind($abstract, $concret) {
        if ($concret instanceof Closure) {
            $this->binds[$abstract] = $concret;
        } else {
            $this->instances[$abstract] = $concret;
        }
    }
    //解析对象
    public function make($abstract, $parameters = []) {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        array_unshift($parameters, $this);
        var_dump($parameters);
        //$this->binds[$abstract]变量是一个闭包函数
        //$parameters中第一个变量为当前容器对象，用于使用make方法解析对应注册好的对象
        return call_user_func_array($this->binds[$abstract], $parameters);
    }
}

interface cacheHandle{
    public function get($key);
}

class Tredis implements cacheHandle {
    public function get($key)
    {
        // TODO: Implement get() method.
        echo '我是redis,获取' . $key;
    }
}

class Tmemcache implements cacheHandle {
    public function get($key)
    {
        // TODO: Implement get() method.
        echo '我是memcache,获取' . $key;
    }
}

class cache {
    private $cacheHandle = null;

    public function __construct(cacheHandle $cacheHandle)
    {
        $this->cacheHandle = $cacheHandle;
    }
    public function get($key)
    {
        return $this->cacheHandle->get($key);
    }
}

$container = new container();
$cacheHandleName = 'Tredis';
//$cacheHandleName = 'Tmemcache';
$container->bind('Tredis', function ($container) {
    return new Tredis();
});
$container->bind('Tmemcache', function ($container) {
    return new Tmemcache();
});
$container->bind('cache', function ($container, $cacheHandleName) {
    return new cache($container->make($cacheHandleName));
});

$cache = $container->make('cache', [$cacheHandleName]);
$cache->get('3333');
