<?php declare(strict_types=1);


namespace Apollo\Process;

use Apollo\Apollo;
use Apollo\Exception\ApolloException;
use Swoft\Apollo\Config;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Bean\BeanFactory;
use Swoft\Process\Process;
use Swoft\Process\UserProcess;

/**
 * Class ApolloProcess
 * @package Apollo\Process
 * @Bean()
 */
class ApolloProcess extends UserProcess
{

    /**
     * @Inject()
     * @var Config
     */
    private $apollo;

    /**
     * Run
     * @param Process $process
     * @throws ApolloException
     * @throws \ReflectionException
     * @throws \Swoft\Apollo\Exception\ApolloException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function run(Process $process): void
    {
        $process->name('apollo process');
        $namespaces = \config('apollo.namespaces', ['application']);
        if (!is_array($namespaces)) {
            throw new ApolloException('apollo.namespaces must be array');
        }
        /**
         * @var Apollo
         */
        $config = BeanFactory::getBean('apolloConfig');
        $this->apollo->listen($namespaces, [$config, 'listen']);
    }
}
