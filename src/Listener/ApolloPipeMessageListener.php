<?php declare(strict_types=1);


namespace Apollo\Listener;


use Apollo\ConfigPool;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\BeanFactory;
use Swoft\Server\Contract\PipeMessageInterface;
use Swoole\Server;

/**
 * Class ApolloPipeMessageListener
 * @package App\Apollo\src\Listener
 * @Bean()
 */
class ApolloPipeMessageListener implements PipeMessageInterface
{
    /**
     * Pipe message event
     *
     * @param Server $server
     * @param int $srcWorkerId
     * @param mixed $message
     */
    public function onPipeMessage(Server $server, int $srcWorkerId, $message): void
    {
        $message = json_decode($message, true);
        if (empty($message)) {
            return;
        }
        /**
         * @var ConfigPool $config
         */
        $config = BeanFactory::getBean('configPool');
        foreach ($message as $application) {
            $config->set($application['namespaceName'], json_encode($application['configurations']));
        }
    }
}
