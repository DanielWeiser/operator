<?php

namespace app\commands;

use app\models\Queue;
use app\services\HandleQueue;
use yii\console\Controller;
use yii\console\ExitCode;

class ClientController extends Controller
{
    private int $serviceId;

    /**
     * @return int Exit code
     */
    public function actionIndex($serviceId): int
    {
        $this->serviceId = $serviceId;
        $queueHandler = new HandleQueue();

        if (!$this->handleStatusCode($queueHandler->handleService($serviceId))) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }

    /**
     * @param int $statusCode
     * @return bool
     */
    private function handleStatusCode(int $statusCode): bool
    {
        if (HandleQueue::STATUS_NO_FREE_OPERATORS === $statusCode) {
            $queue = new Queue();
            $queue->setAttribute('service_id', $this->serviceId);

            if (!$queue->save()) {
                return false;
            }

            $this->stdout("No free operators\n");
        }

        return true;
    }
}
