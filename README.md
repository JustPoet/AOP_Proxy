# AOP_Proxy
一个简单的代理实现,可以帮助实现面向切面编程(AOP)

## Install
```shell
composer require zean/proxy
```

## Usage

Example

```php
<?php
/**
 * 真正的业务类
 */
class TestService
{
    public function test($param)
    {
        echo $param . PHP_EOL;
    }
}

/**
 * 在业务方法,前后加日志,通过环绕增强来实现
 * 只需要实现AroundAdvice接口,完成before、after、exception方法
 */
class LogAdvice implements AroundAdvice
{
    /**
     * @param $method
     * @param $parameters
     * @param $className
     *
     * @return mixed
     */
    public function before($method, $parameters, $className)
    {
        echo 'start log' . PHP_EOL;
    }

    /**
     * @param $method
     * @param $parameters
     * @param $result
     * @param $className
     *
     * @return mixed
     */
    public function after($method, $parameters, $result, $className)
    {
        echo 'end' . PHP_EOL;
    }

    /**
     * @param string $method
     * @param mixed  $parameters
     * @param string $className
     * @param Exception  $exception
     */
    public function exception($method, $parameters, $className, $exception)
    {
        echo 'what?' . $exception->getMessage() . PHP_EOL;
    }
}

$logProxy = AOPProxy::create(new TestService());
$logProxy->addAdvice(new LogAdvice());
$logProxy->test('test');

```

result:
start log<br>
test<br>
end log

前置增强需要实现BeforeAdvice、后置增强需要实现AfterAdvice

支持创建单例,create($obj, $useSingleton),当第二个参数为true的时候创建的代理为单例(默认为true)