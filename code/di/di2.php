<?php
/**
 * Description:
 * Date: 2018/12/26
 */
//注入方式2,使用setter函数
class cache {
    private $cacheHandle = null;

    public function set($redisObj) {
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
$cacheObj = new cache();
$cacheObj->set($redisObj);
$cacheObj->get('bbb');
