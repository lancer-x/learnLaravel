<?php
/**
 * Description:
 * User: lixiaoru@guazi.com
 * Date: 2018/12/26
 */
//依赖注入更高级一点的用法，使用接口约定资源类的实现
//这样的好处是以后新增缓存实现时均面向接口编程，只要实现了接口的缓存类的对象都可以被注入到cache对象中，
//而cache对象不用进行任何修改
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
$redisObj = new Tredis();
$memObj = new Tmemcache();
$cacheObj =new cache($redisObj);
$cacheObj->get('aaaa');

$cacheObj = new cache($memObj);
$cacheObj->get('bbb');