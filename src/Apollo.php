<?php declare(strict_types=1);


namespace Apollo;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\BeanFactory;
use Swoft\Http\Server\HttpServer;

/**
 * Class Apollo
 * @package Apollo
 * @Bean("apolloConfig")
 */
class Apollo
{
    /**
     * 监听apollo,并更新配置
     * @param array $data
     */
    public function listen(array $data)
    {
        $this->pushConfigToWorks($data);
    }

    /**
     * @param array $data
     */
    private function pushConfigToWorks(array $data)
    {
        /**
         * @var $server HttpServer
         */
        $httpServer = BeanFactory::getBean('httpServer');
        $setting = $httpServer->getSetting();
        $workerNums = ($setting['worker_num'] ?? 0) + ($setting['task_worker_num'] ?? 0);
        $server = $httpServer->getSwooleServer();
        for ($workId = 0; $workId < $workerNums; $workId++) {
            $server->sendMessage(json_encode($data), $workId);
        }
    }
}
