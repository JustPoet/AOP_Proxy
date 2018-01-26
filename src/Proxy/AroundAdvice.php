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
 * AroundAdvice.php.
 *
 * 环绕增强
 *
 * @author    zhengzean <zhengzean01@gmail.com>
 * @copyright 2016 zhengzean <zhengzean01@gmail.com>
 *
 * @link      https://github.com/ZhengZean
 */
namespace Zean\Proxy;


interface AroundAdvice extends Advice
{
    /**
     * @param $method
     * @param $parameters
     * @param $className
     *
     * @return mixed
     */
    public function before($method, $parameters, $className);

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