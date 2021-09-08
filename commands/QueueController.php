<?php

namespace app\commands;

use app\services\HandleQueue;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\StaleObjectException;

class QueueController extends Controller
{
    /**
     * @return int Exit code
     */
    public function actionHandle(): int
    {
        try {
            $queueHandler = new HandleQueue();
            $queueHandler->run();
        } catch (StaleObjectException | \Throwable $e) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        return ExitCode::OK;
    }
}
