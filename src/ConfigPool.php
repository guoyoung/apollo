<?php declare(strict_types=1);


namespace Apollo;


use Apollo\Contract\ApolloInterface;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class ConfigPool
 * @package App\Apollo\src
 * @Bean("configPool")
 */
class ConfigPool implements ApolloInterface
{
    /**
     * 拉取的配置
     * @var array
     */
    private $configurations = [];

    /**
     * @param $key
     * @param $val
     */
    public function set($key, $val)
    {
        $this->configurations[$key] = $val;
    }

    /**
     * @param null $key
     * @param null $name
     * @return array|mixed|null
     */
    public function get($key = null, $name = null)
    {
        if (null === $key) {
            return $this->configurations;
        }
        if (null === $name) {
            return $this->configurations[$key] ?? null;
        }
        $config = $this->configurations[$key] ?? '';
        $config = json_decode($config, true);
        return $config[$name] ?? null;
    }
}
