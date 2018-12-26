<?php
/**
 * Description:
 * User: lixiaoru@guazi.com
 * Date: 2018/12/26
 */
namespace Test;

class TestOne {
    private $a;
    private $b;
    public function __construct($a = 'aa', $b = 'bb')
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function say()
    {
        echo 'hello';
    }
}