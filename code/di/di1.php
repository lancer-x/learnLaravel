<?php
/**
 * Description:
 * Date: 2018/12/26
 */
//容器 IoCContainer  使用的对象和资源：例如cache对象需要使用redis(用Tredis模拟)资源
//注入方式1，使用构造函数

class cache {
    private $cacheHandle = null;
    public function __construct($redisObj)
    {
        $this->cacheHandle = $redisObj;
    }
    public function get($key)
    {
        return $this->cacheHandle->get($key);
    }
}
class Tredis{
    public function get($key) {
        echo '获取' . $key;
    }
}
$redisObj = new Tredis();
$cacheObj = new cache($redisObj);
$cacheObj->get('aaa');

