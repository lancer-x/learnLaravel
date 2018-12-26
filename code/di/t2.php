<?php
/**
 * Description:
 * User: lixiaoru@guazi.com
 * Date: 2018/12/24
 */
use Test\TestOne;
include '../in.php';

$f = new ReflectionClass(TestOne::class);
$method = $f->getMethods();
print_r($method);

$cons = $f->getConstants();
print_r($cons);

$cons = $f->getProperties();
print_r($cons);

$construtor = $f->getConstructor();
print_r($construtor);

$param = $construtor->getParameters();
print_r($param);

$dependencies = getDependencies($param);

$ins = $f->newInstanceArgs($dependencies);
print_r($ins);

$t = new TestOne();
print_r($t);

//依赖解析
function getDependencies($parameters)
{
    $dependencies = [];
    foreach($parameters as $parameter) {
        $dependency = $parameter->getClass();
        if (is_null($dependency)) {
            if($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                //不是可选参数的为了简单直接赋值为字符串0
                //针对构造方法的必须参数这个情况
                //laravel是通过service provider注册closure到IocContainer,
                //在closure里可以通过return new Class($param1, $param2)来返回类的实例
                //然后在make时回调这个closure即可解析出对象
                //具体细节我会在另一篇文章里面描述
                $dependencies[] = '0';
            }
        } else {
            //递归解析出依赖类的对象
            $dependencies[] = make($parameter->getClass()->name);
        }
    }

    return $dependencies;
}