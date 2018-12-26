<?php
/**
 * Description:
 * Date: 2018/12/26
 */

//以下虽然cache依赖redis,但是redis资源却是在累内部手动初始化的，所以并不是注入方式实现的

class Tredis{
    public function get($key) {
        echo '获取' . $key;
    }
}

class cache {
    private $cacheHandle = null;
    public function __construct()
    {
        $this->cacheHandle = new Tredis();
    }
    public function get($key)
    {
        return $this->cacheHandle->get($key);
    }
}

$cacheObj = new cache();
$cacheObj->get('nodi');