<?php
/*
 * This file is part of the zean/proxy.
 *
 * (c) zhengzean <zhengzean01@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * BeforeAdvice.php.
 *
 * 前置增强
 *
 * @author    zhengzean <zhengzean01@gmail.com>
 * @copyright 2016 zhengzean <zhengzean01@gmail.com>
 *
 * @link      https://github.com/ZhengZean
 */
namespace Zean\Proxy;


interface BeforeAdvice extends Advice
{
    /**
     * @param $method
     * @param $parameters
     * @param $className
     *
     * @return mixed
     */
    public function before($method, $parameters, $className);
}