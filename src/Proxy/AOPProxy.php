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
 * AOPProxy.php.
 *
 * @author    zhengzean <andyzheng1024@gmail.com>
 * @copyright 2016 zhengzean <andyzheng1024@gmail.com>
 *
 * @link      https://github.com/ZhengZean
 */
namespace Zean\Proxy;


use Exception;

class AOPProxy
{
    /**
     * @var object
     */
    private $instance;

    /**
     * @var array
     */
    private $advices = [];

    /**
     * ProxyClient constructor.
     *
     * @param $instance
     */
    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $className = get_class($this->instance);
        $result = [];
        $this->before($method, $parameters, $className);

        try {
            $result = $this->run($method, $parameters);
        } catch (Exception $e) {
            $this->exception($method, $parameters, $className, $e);
        } finally {
            $this->after($method, $parameters, $result, $className);
        }

        return $result;
    }

    /**
     * @param $method
     * @param $parameters
     * @param $className
     */
    public function before($method, $parameters, $className)
    {
        foreach ($this->advices as $advice) {
            if (method_exists($advice, 'before')) {
                $advice->before($method, $parameters, $className);
            }
        }
    }

    public function exception($method, $parameters, $className, $exception)
    {
        foreach ($this->advices as $advice) {
            if (method_exists($advice, 'exception')) {
                $advice->exception($method, $parameters, $className, $exception);
            }
        }
    }

    /**
     * @param $method
     * @param $parameters
     * @param $result
     * @param $className
     */
    public function after($method, $parameters, $result, $className)
    {
        foreach ($this->advices as $advice) {
            if (method_exists($advice, 'after')) {
                $advice->after($method, $parameters, $result, $className);
            }
        }
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     * @throws Exception
     */
    public function run($method, $parameters)
    {
        $result = [];

        if (method_exists($this->instance, $method)) {
            $result = call_user_func_array([$this->instance, $method], $parameters);
        } else {
            throw new Exception('Method dose not exist');
        }

        return $result;
    }


    /**
     * @param Advice $advice
     *
     * @return $this
     */
    public function addAdvice(Advice $advice)
    {
        $this->advices[] = $advice;
        return $this;
    }
}