<?php declare(strict_types=1);


namespace Apollo\Contract;


interface ApolloInterface
{
    /**
     * 获取配置
     * @param null $key
     * @param null $name
     * @return mixed
     */
    public function get($key = null, $name = null);

    /**
     * @param $key
     * @param $val
     * @return mixed
     */
    public function set($key, $val);
}
