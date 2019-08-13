# Apollo
- 基于swoft/apollo，实现监听Apollo，当配置变化时，会自动同步到每个worker，不包括自定义worker。

# 安装
- 通过composer安装
```
composer require gyoung/apollo
```
# 使用
## 基础配置
- 按swoft/apollo在bean.php添加配置
- 在config下新增apollo.php，内容如下：
```
  return [
      'namespaces' => ['application'],         // 命名空间名称，需数组
  ];
```

- 进程通讯需监听pipeMessage事件,bean.php添加(http server为例)：
```
  'httpServer' => [
      ...
        'on' => [
              ...
              SwooleEvent::PIPE_MESSAGE => bean(\Apollo\Listener\ApolloPipeMessageListener::class),
          ],
      ...
  ],
```

- 监听Apollo使用自定义进程,bean.php添加(http server为例)：
```
'httpServer' => [
      ...
      'process' => [
          ...
          'apollo' => bean(\Apollo\Process\ApolloProcess::class)
      ],
      ...
  ],
```

- 获取配置
```
/**
 * @var $config ConfigPool
 */
$config = BeanFactory::getBean('configPool');
$config->get();                   //获取所有配置
$config->get($namespace);         //获取指定命名空间配置
$config->get($namespace, $name);  //获取指定命名空间下某个名称的配置
```
