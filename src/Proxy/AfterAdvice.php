<?php
/*
 * This file is part of the zean/proxy.
 *
 * (c) zhengzean <andyzheng1024@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * AfterAdvice.php.
 *
 * 后置增强
 *
 * @author    zhengzean <andyzheng1024@gmail.com>
 * @copyright 2016 zhengzean <andyzheng1024@gmail.com>
 *
 * @link      https://github.com/ZhengZean
 */
namespace Zean\Proxy;

interface AfterAdvice extends Advice
{
    /**
     * @param $method
     * @param $parameters
     * @param $result
     * @param $className
     *
     * @return mixed
     */
    public function after($method, $parameters, $result, $className);
}