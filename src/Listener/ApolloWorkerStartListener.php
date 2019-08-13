<?php declare(strict_types=1);


namespace Apollo\Listener;


use Apollo\ConfigPool;
use Apollo\Exception\ApolloException;
use Swoft\Apollo\Config;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Bean\BeanFactory;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Server\SwooleEvent;

/**
 * Class ApolloWorkerStartListener
 * @package Apollo\Listener
 * @Listener(SwooleEvent::WORKER_START)
 */
class ApolloWorkerStartListener implements EventHandlerInterface
{
    /**
     * @Inject()
     * @var Config
     */
    private $apollo;

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        $namespaces = \config('apollo.namespaces', ['application']);
        if (!is_array($namespaces)) {
            throw new ApolloException('apollo.namespaces must be array');
        }
        $configs = $this->apollo->batchPull($namespaces);
        if (empty($configs)) {
            return;
        }
        /**
         * @var ConfigPool $configPool
         */
        $configPool = BeanFactory::getBean('configPool');
        foreach ($configs as $application) {
            $configPool->set($application['namespaceName'], json_encode($application['configurations']));
        }
    }
}
