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
 * Advice.php.
 *
 * 增强接口
 *
 * @author    zhengzean <zhengzean01@gmail.com>
 * @copyright 2016 zhengzean <zhengzean01@gmail.com>
 *
 * @link      https://github.com/ZhengZean
 */
namespace Zean\Proxy;

interface Advice
{
    /**
     * @param string $method
     * @param mixed $parameters
     * @param string $className
     * @param mixed $exception
     *
     */
    public function exception($method, $parameters, $className, $exception);
}