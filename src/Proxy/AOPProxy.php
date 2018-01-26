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
 * AOPProxy.php.
 *
 * @author    zhengzean <zhengzean01@gmail.com>
 * @copyright 2016 zhengzean <zhengzean01@gmail.com>
 *
 * @link      https://github.com/ZhengZean
 */

namespace Zean\Proxy;


use Exception;

class AOPProxy
{
    /**
     * target
     *
     * @var
     */
    private $targetObject;

    /**
     * @var AOPProxy
     */
    private static $instance;

    /**
     * @var array
     */
    private $advices = [];

    /**
     * ProxyClient constructor.
     *
     * @param $targetObject
     */
    private function __construct($targetObject = null)
    {
        if ($targetObject) {
            $this->targetObject = $targetObject;
        }
    }

    /**
     * 创建代理
     *
     * @param object $targetObject 目标对象
     * @param bool   $singleton    是否单例
     *
     * @return AOPProxy|static
     */
    public static function create($targetObject = null, $singleton = true)
    {
        if ($singleton) {
            if (null === static::$instance) {
                static::$instance = new static($targetObject);
            }

            return static::$instance;
        } else {
            return new static($targetObject);
        }
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $className = get_class($this->targetObject);
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
                $advice->exception($method, $parameters, $className,
                    $exception);
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
        if (method_exists($this->targetObject, $method)) {
            return call_user_func_array([$this->targetObject, $method],
                $parameters);
        } else {
            throw new Exception('Method dose not exist');
        }
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

    /**
     * @param object $targetObject
     */
    public function setTargetObject(object $targetObject)
    {
        $this->targetObject = $targetObject;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}