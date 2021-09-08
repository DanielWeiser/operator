<?php

namespace app\services;

use app\models\Operator;
use app\models\Queue;
use app\models\Service;
use yii\db\StaleObjectException;

class HandleQueue
{
    const STATUS_OK = 0;
    const STATUS_NO_FREE_OPERATORS = 1;
    const STATUS_UNEXPECTED_ERROR = 2;

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function run(): void
    {
        $services = Queue::find()->all();

        foreach ($services as $service) {
            if (self::STATUS_OK === $this->handleService($service->getAttribute('service_id'))) {
                $service->delete();
            }
        }
    }

    /**
     * @param int $serviceId
     * @return int
     */
    public function handleService(int $serviceId): int
    {
        $service = Service::find()->where(['id' => $serviceId])->one();

        if (!$service) {
            return self::STATUS_UNEXPECTED_ERROR;
        }

        $freeOperator = Operator::getFreeOperator($service->getOperators());

        if (!$freeOperator) {
            return self::STATUS_NO_FREE_OPERATORS;
        }

        $endTimestamp = strtotime('now') + $service->getAttribute('duration');
        $freeOperator->setAttribute('end_service_at', $endTimestamp);

        if (!$freeOperator->save()) {
            return self::STATUS_UNEXPECTED_ERROR;
        }

        return self::STATUS_OK;
    }
}
